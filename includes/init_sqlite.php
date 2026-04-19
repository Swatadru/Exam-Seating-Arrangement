<?php
/**
 * SQLite Database Initializer (Robust Version)
 * Properly merges ALTER TABLE constraints into CREATE TABLE definitions.
 */

function init_sqlite($sql_file, $sqlite_file) {
    if (file_exists($sqlite_file)) {
        return; // Already initialized
    }

    $db = new PDO("sqlite:" . $sqlite_file);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $original_sql = file_get_contents($sql_file);

    // 1. Extract and map AUTO_INCREMENT / PRIMARY KEY from ALTER TABLE statements
    $auto_increments = [];
    preg_match_all('/ALTER TABLE `(\w+)`.*?MODIFY `(\w+)`.*?AUTO_INCREMENT/is', $original_sql, $ai_matches);
    for ($i = 0; $i < count($ai_matches[0]); $i++) {
        $auto_increments[$ai_matches[1][$i]] = $ai_matches[2][$i];
    }

    $primary_keys = [];
    preg_match_all('/ALTER TABLE `(\w+)`.*?ADD PRIMARY KEY \(`(\w+)`\)/is', $original_sql, $pk_matches);
    for ($i = 0; $i < count($pk_matches[0]); $i++) {
        // Only add if not already in auto_increments (since AI implies PK in SQLite)
        if (!isset($auto_increments[$ai_matches[1][$i]]) || $auto_increments[$ai_matches[1][$i]] != $pk_matches[2][$i]) {
            $primary_keys[$pk_matches[1][$i]] = $pk_matches[2][$i];
        }
    }

    // 2. Process CREATE TABLE statements
    preg_match_all('/CREATE TABLE `(\w+)` \((.*?)\) ENGINE=InnoDB/is', $original_sql, $ct_matches);
    
    $sqlite_queries = [];
    for ($i = 0; $i < count($ct_matches[0]); $i++) {
        $table_name = $ct_matches[1][$i];
        $columns_raw = $ct_matches[2][$i];
        
        $lines = explode(",\n", $columns_raw);
        $new_lines = [];
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // Extract column name
            if (preg_match('/^`(\w+)`/', $line, $col_match)) {
                $col_name = $col_match[1];
                
                // Convert types
                $line = preg_match('/int\(\d+\)/i', $line) ? preg_replace('/int\(\d+\)/i', 'INTEGER', $line) : $line;
                
                // Add PK/AI if matches
                if (isset($auto_increments[$table_name]) && $auto_increments[$table_name] == $col_name) {
                    $line = preg_replace('/NOT NULL/i', 'PRIMARY KEY AUTOINCREMENT', $line);
                } elseif (isset($primary_keys[$table_name]) && $primary_keys[$table_name] == $col_name) {
                    $line = preg_replace('/NOT NULL/i', 'PRIMARY KEY', $line);
                }
            }
            $new_lines[] = $line;
        }
        
        $sqlite_queries[] = "CREATE TABLE `$table_name` (" . implode(", ", $new_lines) . ");";
    }

    // 3. Extract INSERT statements
    preg_match_all('/INSERT INTO `(\w+)` (.*?;)/is', $original_sql, $ins_matches);
    for ($i = 0; $i < count($ins_matches[0]); $i++) {
        $sqlite_queries[] = "INSERT INTO `" . $ins_matches[1][$i] . "` " . $ins_matches[2][$i];
    }

    // 4. Execute all queries
    foreach ($sqlite_queries as $q) {
        try {
            $db->exec($q);
        } catch (PDOException $e) {
            error_log("SQLite Init Error: " . $e->getMessage() . " in query: " . substr($q, 0, 100));
        }
    }
}
?>
