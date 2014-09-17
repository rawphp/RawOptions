<?php

/**
 * This file is part of RawPHP - a PHP Framework.
 * 
 * Copyright (c) 2014 RawPHP.org
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * 
 * PHP version 5.4
 * 
 * @category  PHP
 * @package   RawPHP/Core/Tests
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\Core\Models;

use RawPHP\RawMigrator\Test\DBTestCase;
use RawPHP\RawOptions\Options;
use RawPHP\RawOptions\IOptions;

/**
 * The options tests
 * 
 * @category  PHP
 * @package   RawPHP/Core/Tests
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class OptionsTest extends DBTestCase
{
    /**
     * @var IOptions
     */
    public $options;
    
    /**
     * Setup before test suite run.
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        
        self::$migrator->migrationPath = MIGRATIONS_DIR;
    }
    
    /**
     * Cleanup after test suite run.
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        
        if ( file_exists( TEST_LOCK_FILE ) )
        {
            unlink( TEST_LOCK_FILE );
        }
    }
    
    /**
     * Setup before each test.
     * 
     * @global IDatabase $db database instance
     */
    public function setUp( )
    {
        parent::setUp( );
        
        $this->options = new Options( self::$db );
        
    }
    
    /**
     * Cleanup after each test.
     */
    public function tearDown( )
    {
        parent::tearDown( );
        
        $this->options = NULL;
    }
    
    /**
     * Test adding an option.
     */
    public function testAddOption( )
    {
        $key   = 'test_key';
        $value = 'test_value';
        
        $this->assertTrue( $this->options->addOption( $key, $value ) );
    }
    
    /**
     * Test exception is thrown if key already exists.
     * 
     * @expectedException RawPHP\RawOptions\DuplicateKeyException
     */
    public function testAddOptionDuplicateKeyThrowsException( )
    {
        $key   = 'test_key';
        $value = 'test_value';
        
        $this->assertTrue( $this->options->addOption( $key, $value ) );
        
        $this->options->addOption( $key, $value );
    }
    
    /**
     * Test getting existing option.
     */
    public function testGetOption( )
    {
        $key   = 'test_key';
        $value = 'test_value';
        
        $this->assertTrue( $this->options->addOption( $key, $value ) );
        
        $result = $this->options->getOption( $key );
        
        $this->assertEquals( $value, $result );
    }
    
    /**
     * Test updating an option.
     */
    public function testUpdateOption( )
    {
        $key      = 'test_key';
        $value    = 'test_value';
        $newValue = 'new_test_value';
        
        $this->assertTrue( $this->options->addOption( $key, $value ) );
        
        $this->assertTrue( $this->options->updateOption( $key, $newValue ) );
        
        $result = $this->options->getOption( $key );
        
        $this->assertEquals( $newValue, $result );
    }
    
    /**
     * Test deleting an option.
     */
    public function testDeleteOption( )
    {
        $key   = 'test_key';
        $value = 'test_value';
        
        $this->assertTrue( $this->options->addOption( $key, $value ) );
        
        $this->assertTrue( $this->options->deleteOption( $key ) );
        
        $result = $this->options->getOption( $key );
        
        $this->assertNull( $result );
    }
}