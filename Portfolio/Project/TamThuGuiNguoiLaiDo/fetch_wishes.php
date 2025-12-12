<?php
// Simple JSON endpoint to return wishes by offset/limit
require_once __DIR__ . '/connect.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode(['wishes' => [], 'error' => 'DB connection missing'], JSON_UNESCAPED_UNICODE);
    exit;
}

$conn->set_charset('utf8mb4');

// ensure table exists (same schema as other scripts)
$createSql = "CREATE TABLE IF NOT EXISTS wishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) DEFAULT NULL,
    message TEXT NOT NULL,
    relationship VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if ($conn->query($createSql) === false) {
    echo json_encode(['wishes' => [], 'error' => 'Failed to ensure table: ' . $conn->error], JSON_UNESCAPED_UNICODE);
    $conn->close();
    exit;
}

// validate params
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = max(1, min(100, $limit));
$offset = max(0, $offset);

$stmt = $conn->prepare("SELECT id, name, message, relationship, created_at FROM wishes ORDER BY created_at DESC LIMIT ? OFFSET ?");
if (!$stmt) {
    echo json_encode(['wishes' => [], 'error' => 'Prepare failed: ' . $conn->error], JSON_UNESCAPED_UNICODE);
    $conn->close();
    exit;
}

$stmt->bind_param('ii', $limit, $offset);
if (!$stmt->execute()) {
    echo json_encode(['wishes' => [], 'error' => 'Execute failed: ' . $stmt->error], JSON_UNESCAPED_UNICODE);
    $stmt->close();
    $conn->close();
    exit;
}

$result = $stmt->get_result();
$wishes = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        // keep raw created_at (client will format)
        $wishes[] = $row;
    }
    $result->free();
}
$stmt->close();

// also return total count to help client UI
$total = null;
if ($res = $conn->query("SELECT COUNT(*) AS cnt FROM wishes")) {
    $r = $res->fetch_assoc();
    $total = isset($r['cnt']) ? (int)$r['cnt'] : 0;
    $res->free();
}

echo json_encode(['wishes' => $wishes, 'total' => $total], JSON_UNESCAPED_UNICODE);
$conn->close();
exit;
