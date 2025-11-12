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
 * Make a request to Supabase REST API
 * 
 * @param string $table Table name
 * @param string $method HTTP method (GET, POST, PATCH, DELETE)
 * @param array $filters Query filters for GET requests
 * @param array $data Data for POST/PATCH requests
 * @param bool $useServiceKey Use service key for admin operations
 * @return array Response data
 */
function supabaseRequest($table, $method = 'GET', $filters = [], $data = null, $useServiceKey = false) {
    $url = SUPABASE_URL . '/rest/v1/' . $table;
    
    // Build query string for filters
    if (!empty($filters) && $method === 'GET') {
        $queryParams = [];
        foreach ($filters as $key => $value) {
            if (is_array($value)) {
                // Handle operators like eq, gt, lt, etc.
                $operator = $value['operator'] ?? 'eq';
                $queryParams[] = $key . '=' . $operator . '.' . urlencode($value['value']);
            } else {
                $queryParams[] = $key . '=eq.' . urlencode($value);
            }
        }
        $url .= '?' . implode('&', $queryParams);
    }
    
    // Setup headers
    $headers = [
        'apikey: ' . ($useServiceKey ? SUPABASE_SERVICE_KEY : SUPABASE_KEY),
        'Authorization: Bearer ' . ($useServiceKey ? SUPABASE_SERVICE_KEY : SUPABASE_KEY),
        'Content-Type: application/json',
        'Prefer: return=representation'
    ];
    
    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    if ($data !== null && in_array($method, ['POST', 'PATCH'])) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode >= 400) {
        error_log("Supabase Error: " . $response);
        return ['error' => true, 'message' => 'Database operation failed', 'details' => $response];
    }
    
    return json_decode($response, true) ?: [];
}

/**
 * Select data from Supabase
 * 
 * @param string $table Table name
 * @param array $filters Filters to apply
 * @param string $select Columns to select (default: *)
 * @param string $order Order by clause
 * @param int $limit Limit results
 * @return array
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
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode >= 400) {
        error_log("Supabase Select Error: " . $response);
        return [];
    }
    
    return json_decode($response, true) ?: [];
}

/**
 * Insert data into Supabase
 * 
 * @param string $table Table name
 * @param array $data Data to insert
 * @return array
 */
function supabaseInsert($table, $data) {
    return supabaseRequest($table, 'POST', [], $data);
}

/**
 * Update data in Supabase
 * 
 * @param string $table Table name
 * @param array $filters Filters to identify rows
 * @param array $data Data to update
 * @return array
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
 * 
 * @param string $table Table name
 * @param array $filters Filters to identify rows
 * @return bool
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
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return $httpCode >= 200 && $httpCode < 300;
}

/**
 * Execute a Supabase RPC (stored procedure)
 * 
 * @param string $functionName Function name
 * @param array $params Parameters
 * @return array
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
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode >= 400) {
        error_log("Supabase RPC Error: " . $response);
        return ['error' => true, 'message' => 'RPC call failed'];
    }
    
    return json_decode($response, true) ?: [];
}

// Backward compatibility - create a mock $conn object for existing code
class SupabaseConnection {
    public function query($sql) {
        // This is a placeholder - you should refactor code to use the new functions
        error_log("Warning: Direct SQL query attempted: " . $sql);
        return new SupabaseResult([]);
    }
    
    public function prepare($sql) {
        // This is a placeholder - you should refactor code to use the new functions
        return new SupabaseStatement();
    }
}

class SupabaseResult {
    private $data;
    public $num_rows;
    
    public function __construct($data) {
        $this->data = is_array($data) ? $data : [];
        $this->num_rows = count($this->data);
    }
    
    public function fetch_assoc() {
        if (empty($this->data)) {
            return null;
        }
        return array_shift($this->data);
    }
    
    public function fetch_all($mode = MYSQLI_ASSOC) {
        return $this->data;
    }
}

class SupabaseStatement {
    private $params = [];
    
    public function bind_param($types, ...$vars) {
        $this->params = $vars;
    }
    
    public function execute() {
        // Placeholder
        return true;
    }
    
    public function get_result() {
        return new SupabaseResult([]);
    }
    
    public function store_result() {
        // Placeholder
    }
}

$conn = new SupabaseConnection();