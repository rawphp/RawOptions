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
 * @package   RawPHP/RawOptions
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawOptions;

use RawPHP\RawBase\Component;
use RawPHP\RawOptions\IOptions;
use RawPHP\RawDatabase\IDatabase;
use RawPHP\RawOptions\DuplicateKeyException;

/**
 * The options service class.
 * 
 * @category  PHP
 * @package   RawPHP/RawOptions
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class Options extends Component implements IOptions
{
    /**
     * @var IDatabase
     */
    public $db;
    
    /**
     * Constructs a new instance of the options service.
     * 
     * @param IDatabase $db database instance
     */
    public function __construct( IDatabase $db )
    {
        $this->db = $db;
    }
    
    /**
     * Gets the option value for a key.
     * 
     * @param string $key the option key
     * 
     * @return string the option value if exists or NULL
     */
    public function getOption( $key )
    {
        $k = $this->db->prepareString( $key );
        
        $query = "SELECT option_value FROM options WHERE option_name = '$k'";
        
        $result = $this->db->query( $query );
        
        if ( !empty( $result ) )
        {
            return $result[ 0 ][ 'option_value' ];
        }
        
        return NULL;
    }
    
    /**
     * Adds an option record to the database.
     * 
     * @param string $key   the option key
     * @param string $value the option value
     * 
     * @return bool TRUE on success, FALSE on failure
     * 
     * @throws DuplicateKeyException if the key already exists
     */
    public function addOption( $key, $value )
    {
        $k = $this->db->prepareString( $key );
        $v = $this->db->prepareString( $value );
        
        $query = "INSERT INTO options ( option_name, option_value ) VALUES ( ";
        
        $query .= "'$k', ";
        $query .= "'$v'";
        
        $query .= " )";
        
        $result = $this->db->insert( $query );
        
        $error = $this->db->getError( );
        
        if ( !empty( $error ) )
        {
            if ( FALSE !== strstr( $error, 'Duplicate entry' ) )
            {
                throw new DuplicateKeyException( 'The option key: ' . $k . ' already exists' );
            }
        }
        
        return FALSE !== $result;
    }
    
    /**
     * Updates an option value in the database.
     * 
     * @param string $key   option name
     * @param string $value option value
     * 
     * @return bool TRUE on success, FALSE on failure
     */
    public function updateOption( $key, $value )
    {
        $k = $this->db->prepareString( $key );
        $v = $this->db->prepareString( $value );
        
        $query = "UPDATE options SET ";
        
        $query .= "option_value = '$v' ";
        
        $query .= "WHERE option_name = '$k'";
        
        $result = $this->db->execute( $query );
        
        return 1 >= $result;
    }
    
    /**
     * Deletes an option from the database.
     * 
     * @param string $key option name
     * 
     * @return bool TRUE on success, FALSE on failure
     */
    public function deleteOption( $key )
    {
        $k = $this->db->prepareString( $key );
        
        $query = "DELETE FROM options WHERE option_name = '$k'";
        
        $result = $this->db->execute( $query );
        
        return 1 === $result;
    }
}