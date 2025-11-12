<?php

// Load environment variables from .env file if it exists
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

// Supabase Configuration
define('SUPABASE_URL', $_ENV['SUPABASE_URL'] ?? '');
define('SUPABASE_KEY', $_ENV['SUPABASE_KEY'] ?? '');
define('SUPABASE_SERVICE_KEY', $_ENV['SUPABASE_SERVICE_KEY'] ?? '');

// Validate configuration
if (empty(SUPABASE_URL) || empty(SUPABASE_KEY)) {
    die("Error: Supabase configuration is missing. Please check your .env file.");
}

/**
 * Enhanced Select with better error handling
 */
function supabaseSelect($table, $filters = [], $select = '*', $order = null, $limit = null) {
    $url = SUPABASE_URL . '/rest/v1/' . $table . '?select=' . urlencode($select);
    
    // Add filters
    foreach ($filters as $key => $value) {
        if (is_array($value)) {
            $operator = $value['operator'] ?? 'eq';
            $url .= '&' . $key . '=' . $operator . '.' . urlencode($value['value']);
        } else {
            $url .= '&' . $key . '=eq.' . urlencode($value);
        }
    }
    
    // Add order
    if ($order) {
        $url .= '&order=' . urlencode($order);
    }
    
    // Add limit
    if ($limit) {
        $url .= '&limit=' . $limit;
    }
    
    $headers = [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    // Debug logging (remove in production)
    if ($httpCode >= 400) {
        error_log("=== SUPABASE SELECT ERROR ===");
        error_log("URL: " . $url);
        error_log("HTTP Code: " . $httpCode);
        error_log("Response: " . $response);
        error_log("cURL Error: " . $curlError);
        return [];
    }
    
    if ($curlError) {
        error_log("cURL Error in supabaseSelect: " . $curlError);
        return [];
    }
    
    $decoded = json_decode($response, true);
    return is_array($decoded) ? $decoded : [];
}

/**
 * Insert data into Supabase
 */
function supabaseInsert($table, $data) {
    $url = SUPABASE_URL . '/rest/v1/' . $table;
    
    $headers = [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
        'Prefer: return=representation'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode >= 400) {
        error_log("Supabase Insert Error: " . $response);
        return ['error' => true, 'message' => 'Insert failed', 'details' => $response];
    }
    
    return json_decode($response, true) ?: [];
}

/**
 * Update data in Supabase
 */
function supabaseUpdate($table, $filters, $data) {
    $url = SUPABASE_URL . '/rest/v1/' . $table;
    
    // Add filters
    $queryParams = [];
    foreach ($filters as $key => $value) {
        if (is_array($value)) {
            $operator = $value['operator'] ?? 'eq';
            $queryParams[] = $key . '=' . $operator . '.' . urlencode($value['value']);
        } else {
            $queryParams[] = $key . '=eq.' . urlencode($value);
        }
    }
    $url .= '?' . implode('&', $queryParams);
    
    $headers = [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
        'Prefer: return=representation'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode >= 400) {
        error_log("Supabase Update Error: " . $response);
        return ['error' => true, 'message' => 'Update failed'];
    }
    
    return json_decode($response, true) ?: [];
}

/**
 * Delete data from Supabase
 */
function supabaseDelete($table, $filters) {
    $url = SUPABASE_URL . '/rest/v1/' . $table;
    
    // Add filters
    $queryParams = [];
    foreach ($filters as $key => $value) {
        if (is_array($value)) {
            $operator = $value['operator'] ?? 'eq';
            $queryParams[] = $key . '=' . $operator . '.' . urlencode($value['value']);
        } else {
            $queryParams[] = $key . '=eq.' . urlencode($value);
        }
    }
    $url .= '?' . implode('&', $queryParams);
    
    $headers = [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return $httpCode >= 200 && $httpCode < 300;
}

/**
 * Execute a Supabase RPC (stored procedure)
 */
function supabaseRPC($functionName, $params = []) {
    $url = SUPABASE_URL . '/rest/v1/rpc/' . $functionName;
    
    $headers = [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode >= 400) {
        error_log("Supabase RPC Error: " . $response);
        return ['error' => true, 'message' => 'RPC call failed'];
    }
    
    return json_decode($response, true) ?: [];
}

// DO NOT CREATE MOCK $conn OBJECT - Remove all legacy MySQL code