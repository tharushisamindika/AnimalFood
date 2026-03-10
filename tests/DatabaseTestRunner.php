<?php

/**
 * Database-specific testing for Animal Food System
 */

class DatabaseTestRunner
{
    private $results = [];
    private $pdo;

    public function __construct()
    {
        echo "🗄️ Database Testing Started\n";
        echo "===========================\n\n";
    }

    public function runDatabaseTests()
    {
        $this->testDatabaseConnection();
        $this->testTables();
        $this->testCategoryFunctionality();
        $this->testProductFunctionality();
        $this->testRelationships();
        $this->generateReport();
    }

    private function testDatabaseConnection()
    {
        echo "🔌 Testing Database Connection...\n";
        
        try {
            // Try SQLite connection (default)
            $dbPath = __DIR__ . '/../database/database.sqlite';
            if (file_exists($dbPath)) {
                $this->pdo = new PDO('sqlite:' . $dbPath);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->addResult('SQLite Connection', true, 'Connected to SQLite database');
                
                // Test database is writable
                $this->pdo->exec("CREATE TABLE IF NOT EXISTS test_table (id INTEGER)");
                $this->pdo->exec("DROP TABLE test_table");
                $this->addResult('Database Writable', true, 'Database is writable');
            } else {
                $this->addResult('SQLite File', false, 'database.sqlite file not found');
            }
        } catch (Exception $e) {
            $this->addResult('Database Connection', false, $e->getMessage());
        }
        
        echo "\n";
    }

    private function testTables()
    {
        echo "📋 Testing Database Tables...\n";
        
        if (!$this->pdo) {
            $this->addResult('Table Tests', false, 'No database connection');
            return;
        }

        $requiredTables = [
            'users' => ['id', 'name', 'email', 'password'],
            'categories' => ['id', 'name', 'description', 'is_active'],
            'products' => ['id', 'name', 'category', 'category_id', 'price'],
            'customers' => ['id', 'name', 'email'],
            'suppliers' => ['id', 'name', 'contact'],
            'orders' => ['id', 'customer_id', 'total'],
            'order_items' => ['id', 'order_id', 'product_id'],
            'migrations' => ['id', 'migration', 'batch']
        ];

        foreach ($requiredTables as $table => $columns) {
            try {
                // Check if table exists
                $stmt = $this->pdo->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name=?");
                $stmt->execute([$table]);
                $exists = $stmt->fetch() !== false;
                
                if ($exists) {
                    $this->addResult("Table '{$table}' exists", true, 'Table found');
                    
                    // Check columns
                    $stmt = $this->pdo->prepare("PRAGMA table_info({$table})");
                    $stmt->execute();
                    $tableColumns = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
                    
                    $missingColumns = array_diff($columns, $tableColumns);
                    if (empty($missingColumns)) {
                        $this->addResult("Table '{$table}' structure", true, 'All required columns present');
                    } else {
                        $this->addResult("Table '{$table}' structure", false, 'Missing columns: ' . implode(', ', $missingColumns));
                    }
                } else {
                    $this->addResult("Table '{$table}' exists", false, 'Table not found');
                }
            } catch (Exception $e) {
                $this->addResult("Table '{$table}' test", false, $e->getMessage());
            }
        }
        
        echo "\n";
    }

    private function testCategoryFunctionality()
    {
        echo "📂 Testing Category Operations...\n";
        
        if (!$this->pdo) {
            $this->addResult('Category Tests', false, 'No database connection');
            return;
        }

        try {
            // Test category insertion
            $stmt = $this->pdo->prepare("INSERT INTO categories (name, description, is_active) VALUES (?, ?, ?)");
            $result = $stmt->execute(['Test Category', 'Test Description', 1]);
            $categoryId = $this->pdo->lastInsertId();
            $this->addResult('Category Insert', $result, 'Test category created');
            
            // Test category retrieval
            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
            $stmt->execute([$categoryId]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->addResult('Category Retrieval', $category !== false, 'Test category retrieved');
            
            // Test category update
            $stmt = $this->pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
            $result = $stmt->execute(['Updated Test Category', $categoryId]);
            $this->addResult('Category Update', $result, 'Test category updated');
            
            // Test unique constraint
            try {
                $stmt = $this->pdo->prepare("INSERT INTO categories (name, description, is_active) VALUES (?, ?, ?)");
                $stmt->execute(['Updated Test Category', 'Duplicate', 1]);
                $this->addResult('Category Unique Constraint', false, 'Unique constraint not working');
            } catch (Exception $e) {
                $this->addResult('Category Unique Constraint', true, 'Unique constraint working');
            }
            
            // Cleanup
            $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$categoryId]);
            
        } catch (Exception $e) {
            $this->addResult('Category Operations', false, $e->getMessage());
        }
        
        echo "\n";
    }

    private function testProductFunctionality()
    {
        echo "📦 Testing Product Operations...\n";
        
        if (!$this->pdo) {
            $this->addResult('Product Tests', false, 'No database connection');
            return;
        }

        try {
            // Create a test category first
            $stmt = $this->pdo->prepare("INSERT INTO categories (name, description, is_active) VALUES (?, ?, ?)");
            $stmt->execute(['Test Product Category', 'For testing products', 1]);
            $categoryId = $this->pdo->lastInsertId();
            
            // Test product insertion
            $stmt = $this->pdo->prepare("INSERT INTO products (name, category, category_id, price, quantity, unit, supplier_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute(['Test Product', 'Test Product Category', $categoryId, 10.99, 100, 'kg', null]);
            $productId = $this->pdo->lastInsertId();
            $this->addResult('Product Insert', $result, 'Test product created');
            
            // Test product-category relationship
            $stmt = $this->pdo->prepare("
                SELECT p.name as product_name, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ?
            ");
            $stmt->execute([$productId]);
            $relationship = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->addResult('Product-Category Relationship', 
                $relationship && $relationship['category_name'] === 'Test Product Category', 
                'Foreign key relationship working'
            );
            
            // Cleanup
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$categoryId]);
            
        } catch (Exception $e) {
            $this->addResult('Product Operations', false, $e->getMessage());
        }
        
        echo "\n";
    }

    private function testRelationships()
    {
        echo "🔗 Testing Database Relationships...\n";
        
        if (!$this->pdo) {
            $this->addResult('Relationship Tests', false, 'No database connection');
            return;
        }

        try {
            // Test foreign key constraints
            $stmt = $this->pdo->query("PRAGMA foreign_keys");
            $foreignKeys = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->addResult('Foreign Keys Enabled', 
                $foreignKeys && $foreignKeys['foreign_keys'] == '1', 
                'Foreign key constraints status'
            );
            
            // Test cascade behavior
            $stmt = $this->pdo->prepare("INSERT INTO categories (name, description, is_active) VALUES (?, ?, ?)");
            $stmt->execute(['Cascade Test Category', 'For testing cascade', 1]);
            $categoryId = $this->pdo->lastInsertId();
            
            $stmt = $this->pdo->prepare("INSERT INTO products (name, category, category_id, price, quantity, unit) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute(['Cascade Test Product', 'Cascade Test Category', $categoryId, 5.99, 50, 'pieces']);
            $productId = $this->pdo->lastInsertId();
            
            // Delete category (should set product.category_id to NULL due to ON DELETE SET NULL)
            $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$categoryId]);
            
            // Check if product still exists but category_id is NULL
            $stmt = $this->pdo->prepare("SELECT category_id FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->addResult('Cascade DELETE SET NULL', 
                $result && $result['category_id'] === null, 
                'ON DELETE SET NULL working'
            );
            
            // Cleanup
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            
        } catch (Exception $e) {
            $this->addResult('Relationship Tests', false, $e->getMessage());
        }
        
        echo "\n";
    }

    private function addResult($test, $passed, $message)
    {
        $this->results[] = [
            'test' => $test,
            'passed' => $passed,
            'message' => $message
        ];
        
        $status = $passed ? '✅ PASS' : '❌ FAIL';
        echo "  {$status} - {$test}: {$message}\n";
    }

    private function generateReport()
    {
        echo "\n📋 DATABASE TEST REPORT\n";
        echo "=======================\n\n";
        
        $totalTests = count($this->results);
        $passedTests = count(array_filter($this->results, function($r) { return $r['passed']; }));
        $failedTests = $totalTests - $passedTests;
        
        echo "📊 Database Summary:\n";
        echo "  Total Tests: {$totalTests}\n";
        echo "  Passed: {$passedTests}\n";
        echo "  Failed: {$failedTests}\n";
        echo "  Success Rate: " . round(($passedTests / $totalTests) * 100, 2) . "%\n\n";
        
        if ($failedTests > 0) {
            echo "❌ Failed Database Tests:\n";
            foreach ($this->results as $result) {
                if (!$result['passed']) {
                    echo "  - {$result['test']}: {$result['message']}\n";
                }
            }
            echo "\n";
        }
    }
}

// Run database tests if executed directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    $tester = new DatabaseTestRunner();
    $tester->runDatabaseTests();
}
