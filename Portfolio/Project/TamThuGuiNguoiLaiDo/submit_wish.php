<?php
// Hiển thị lỗi PHP tạm thời để debug (bỏ hoặc tắt trên production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Đảm bảo chỉ POST được phép
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

require_once 'connect.php';

// kiểm tra kết nối
if (!isset($conn) || !($conn instanceof mysqli)) {
    // lỗi kết nối
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Database connection missing.']);
        exit;
    }
    header('Location: index.php?success=0');
    exit;
}

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$relationship = isset($_POST['relationship']) ? trim($_POST['relationship']) : '';

// detect AJAX
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($message === '') {
    // thông tin thiếu
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Vui lòng nhập lời bạn muốn gửi gắm.']);
        exit;
    }
    header('Location: index.php?success=0');
    exit;
}

// Kiểm tra từ cấm (simple filter)
$banned = [
    'ngu',
    'đần',
    'ngáo',
    'đụ',
    'địt',
    'lồn',
    'cặc',
    'chó',
    'đéo',
    'vãi',
    'vcl',
    'cc',
    'dm',
    'đm',
    'đcm',
    'lợn',
];

// tạo regex an toàn
$pattern = '/\b(' . implode('|', array_map('preg_quote', $banned)) . ')\b/ui';
if (preg_match($pattern, $message) || ($name !== '' && preg_match($pattern, $name))) {
    // nếu vi phạm, không lưu và báo lỗi
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'blocked', 'message' => 'Nội dung chứa từ ngữ không phù hợp.']);
        exit;
    }
    header('Location: index.php?blocked=1');
    exit;
}

// Tạo table nếu chưa tồn tại
$createSql = "CREATE TABLE IF NOT EXISTS wishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) DEFAULT NULL,
    message TEXT NOT NULL,
    relationship VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (!$conn->query($createSql)) {
    // không thể tạo table -> trả lỗi chi tiết cho debug
    $err = $conn->error;
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'DB create table error: ' . $err]);
        exit;
    }
    header('Location: index.php?success=0&err=' . urlencode($err));
    exit;
}

// Chuẩn bị và bind để chống SQL injection
// Dùng NULLIF(?, '') để nếu input là chuỗi rỗng sẽ lưu thành NULL
$stmt = $conn->prepare("INSERT INTO wishes (name, message, relationship) VALUES (NULLIF(?,''), ?, NULLIF(?,''))");
if (!$stmt) {
    $err = $conn->error;
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $err]);
        exit;
    }
    header('Location: index.php?success=0&err=' . urlencode($err));
    exit;
}

$stmt->bind_param('sss', $nameParam, $messageParam, $relationshipParam);
$nameParam = $name; // giữ chuỗi rỗng nếu người dùng không nhập -> SQL NULLIF sẽ chuyển thành NULL
$messageParam = $message;
$relationshipParam = $relationship;

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
        exit;
    }
    header('Location: index.php?success=1');
    exit;
} else {
    $execErr = $stmt->error ?: $conn->error;
    $stmt->close();
    $conn->close();
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Execute failed: ' . $execErr]);
        exit;
    }
    header('Location: index.php?success=0&err=' . urlencode($execErr));
    exit;
}
