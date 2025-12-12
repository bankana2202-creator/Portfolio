<?php
// Load DB connection and fetch wishes before any HTML output
require_once __DIR__ . '/connect.php';

$wishes = [];
$wishCount = 0;
$totalCount = 0; // total number of wishes in DB (for counter)

if (isset($conn) && ($conn instanceof mysqli)) {
    // ensure proper charset
    $conn->set_charset('utf8mb4');

    // ensure table exists (same schema as submit_wish.php)
    $createSql = "CREATE TABLE IF NOT EXISTS wishes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) DEFAULT NULL,
        message TEXT NOT NULL,
        relationship VARCHAR(50) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $conn->query($createSql);

    // get total count
    $cntRes = $conn->query("SELECT COUNT(*) AS cnt FROM wishes");
    if ($cntRes) {
        $row = $cntRes->fetch_assoc();
        $totalCount = (int)($row['cnt'] ?? 0);
        $cntRes->free();
    }

    // fetch first page (6) most recent wishes
    $limit = 6;
    $offset = 0;
    if ($stmt = $conn->prepare("SELECT id, name, message, relationship, created_at FROM wishes ORDER BY created_at DESC LIMIT ? OFFSET ?")) {
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $wishes = $result->fetch_all(MYSQLI_ASSOC);
            $wishCount = count($wishes); // count of currently rendered (<=6)
            $result->free();
        }
        $stmt->close();
    }
}

// helper for safe output
function esc($s)
{
    return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// helper for avatar initials (unicode-safe)
function initials($name)
{
    $name = trim((string)$name);
    if ($name === '') return '??';
    $parts = preg_split('/\s+/u', $name);
    $letters = '';
    $count = 0;
    foreach ($parts as $p) {
        if ($p === '') continue;
        $letters .= mb_strtoupper(mb_substr($p, 0, 1, 'UTF-8'), 'UTF-8');
        $count++;
        if ($count >= 2) break;
    }
    return $letters ?: '??';
}

// translate relationship values to Vietnamese (server-side)
function translateRelationship($rel)
{
    $r = trim((string)$rel);
    if ($r === '') return 'Khách';

    $lower = mb_strtolower($r, 'UTF-8');
    $map = [
        'student'   => 'Sinh viên',
        'sinh viên' => 'Sinh viên',
        'alumni'    => 'Cựu sinh viên',
        'graduate'  => 'Cựu sinh viên',
        'teacher'   => 'Giảng viên',
        'lecturer'  => 'Giảng viên',
        'staff'     => 'Nhân viên',
        'faculty'   => 'Khoa',
        'parent'    => 'Phụ huynh',
        'guest'     => 'Khách',
        'khách'     => 'Khách',
        'admin'     => 'Ban quản trị',
        // thêm mapping khác nếu cần
    ];

    return $map[$lower] ?? $r;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="image/favicon.png">
    <title>Lời Chúc - Đại học Hùng Vương TP.HCM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style2.css">
    <style>
        /* Trên thiết bị điện thoại ẩn navbar và bỏ padding-top để không tạo khoảng trắng */
        @media (max-width: 576px) {

            nav,
            #navbar {
                display: none !important;
            }

            body {
                padding-top: 0 !important;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="nav-container">
            <div class="nav-main">
                <div class="nav-left">
                    <a href="index.php#home" class="nav-logo">
                        <img src="image/logo.png" alt="Logo Trường Đại học Hùng Vương TP.HCM" />
                    </a>
                    <ul class="nav-menu">
                        <li><a href="index.php#home"><i class="fas fa-home"></i> Trang Chủ</a></li>
                        <li><a href="index.php#section2"><i class="fas fa-road"></i> Cột Mốc Lịch Sử</a></li>
                        <li><a href="index.php#section3"><i class="fas fa-images"></i> Khoảnh Khắc Đáng Nhớ</a></li>
                        <li><a href="index.php#section4"><i class="fas fa-heart"></i> Lời Tri Ân</a></li>
                        <li><a href="index.php#section5"><i class="fas fa-envelope"></i> Gửi Lời Chúc</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Home Section -->
    <div id="home" class="hero">
        <img src="./image/banner_goc.jpg" alt="">
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="page-title">
            <h2><i class="fas fa-heart"></i> Lời Chúc Tri Ân</h2>
            <p>Những lời chúc, tâm tình và kỷ niệm đẹp gửi đến Trường Đại học Hùng Vương TP.HCM</p>
        </div>

        <!-- Wish Counter -->
        <div class="wish-counter">
            <h3>Tổng số lời chúc đã nhận</h3>
            <div class="counter-number" id="wishCount"><?php echo $totalCount; ?></div>
            <p>Cảm ơn tất cả các thế hệ giảng viên, cựu sinh viên và sinh viên đã gửi lời chúc đến trường</p>
        </div>

        <!-- Wish Grid -->
        <div class="wish-grid" id="wishGrid">
            <?php
            if ($totalCount === 0):
            ?>
                <div class="no-wishes">Chưa có lời chúc nào. Hãy là người đầu tiên gửi lời chúc!</div>
                <?php
            else:
                foreach ($wishes as $wish):
                    // fallback values
                    $name = $wish['name'] ?? '';
                    $relationship = $wish['relationship'] ?? '';
                    $message = $wish['message'] ?? '';
                    $created = $wish['created_at'] ?? null;
                    $date = $created ? date('d/m/Y', strtotime($created)) : '';
                ?>
                    <div class="wish-card" data-id="<?php echo (int)$wish['id']; ?>">
                        <div class="wish-header">
                            <div class="wish-avatar"><?php echo esc(initials($name)); ?></div>
                            <div class="wish-info">
                                <div class="wish-name"><?php echo $name !== '' ? esc($name) : 'Bạn ẩn danh'; ?></div>
                                <div class="wish-relationship"><i class="fas fa-user-graduate"></i>
                                    <?php echo esc(translateRelationship($relationship)); ?></div>
                                <div class="wish-date"><i class="far fa-clock"></i> <?php echo esc($date); ?></div>
                            </div>
                        </div>
                        <div class="wish-message">
                            <?php echo nl2br(esc($message)); ?>
                        </div>
                        <!-- ĐÃ XÓA PHẦN WISH-ACTIONS VÀ LIKE BUTTON -->
                    </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>

        <!-- Load More Button -->
        <div style="text-align: center; margin: 2rem 0;">
            <button id="loadMore" style="
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                color: white;
                border: none;
                padding: 1rem 2rem;
                border-radius: 6px;
                font-size: 1.1rem;
                cursor: pointer;
                transition: all 0.3s;
            ">
                <i class="fas fa-sync-alt"></i> Xem Thêm Lời Chúc
            </button>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Thông tin liên hệ</h3>
                <p><i class="fas fa-map-marker-alt"></i> Trụ sở chính: 194 Lê Đức Thọ, Phường An Nhơn, Thành phố Hồ Chí
                    Minh</p>
                <p>Cơ sở 1: 736 Nguyễn Trãi, Phường Chợ Lớn, Thành phố Hồ Chí Minh</p>
                <p>Cơ sở 2: 37 Kinh Dương Vương, Phường Phú Lâm, Thành phố Hồ Chí Minh</p>
                <p>Cơ sở 3: Công viên Phần mềm Quang Trung, Phường Trung Mỹ Tây, Thành phố Hồ Chí Minh (Cơ sở thực hành
                    )</p>
                <p><i class="fas fa-phone"></i> (028) 7100 0888 - (028) 7100 1888</p>
                <p><i class="fas fa-envelope"></i> info@dhv.edu.vn | media@dhv.edu.vn</p>
                <p><i class="fas fa-globe"></i><a href="https://dhv.edu.vn" class="dhv"> dhv.edu.vn</a></p>
            </div>

            <div class="footer-section">
                <h3>Liên kết nhanh</h3>
                <ul>
                    <li><i class="fas fa-chevron-right"></i> <a href="index.php#home">Trang Chủ</a></li>
                    <li><i class="fas fa-chevron-right"></i> <a href="index.php#section2">Cột Mốc Lịch Sử</a></li>
                    <li><i class="fas fa-chevron-right"></i> <a href="index.php#section3">Khoảnh Khắc Đáng Nhớ</a></li>
                    <li><i class="fas fa-chevron-right"></i> <a href="index.php#section4">Lời Tri Ân</a></li>
                    <li><i class="fas fa-chevron-right"></i> <a href="index.php#section5">Gửi Lời Chúc</a></li>
                    <li><i class="fas fa-chevron-right"></i> <a href="LoiChuc.php">Tổng Hợp Lời Chúc</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Theo dõi trường</h3>
                <p>Kết nối với Trường Đại học Hùng Vương TP.HCM qua các kênh truyền thông:</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/hungvuonguni"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.youtube.com/@hungvuonguni"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.tiktok.com/@dhv.official"><i class="fab fa-tiktok"></i></a>
                    <a href="https://zalo.me/1822829687649866202" target="_blank">
                        <img src="./image/zalo-icon.png" alt="Zalo" class="zalo-icon">
                    </a>
                </div>
                <h3>My Contact</h3>
                <li><i></i> <a href="contact.html">Click Here</a></li>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 - Chào mừng kỷ niệm 30 năm thành lập Trường Đại học Hùng Vương TP.HCM & kỷ niệm 42 năm Ngày
                Nhà giáo Việt Nam</p>
            <p>Đây là sản phẩm cá nhân, không phải website chính thức của trường !</p>
        </div>
    </footer>

    <!-- Back to top button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </a>

    <script>
        // Back to top button
        const backToTopButton = document.getElementById("backToTop");

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });

        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // ĐÃ XÓA TOÀN BỘ PHẦN LIKE BUTTON FUNCTIONALITY

        // Pagination / Load more
        let offset = <?php echo (int)$wishCount; ?>; // how many already rendered
        const total = <?php echo (int)$totalCount; ?>;
        const pageLimit = 6;
        const loadBtn = document.getElementById('loadMore');

        function escapeHtml(s) {
            const d = document.createTextNode(s);
            const div = document.createElement('div');
            div.appendChild(d);
            return div.innerHTML;
        }

        // translate relationship (client-side) - same mapping as server
        function translateRelationship(rel) {
            if (!rel) return 'Khách';
            const key = String(rel).trim().toLowerCase();
            const map = {
                'student': 'Sinh viên',
                'sinh viên': 'Sinh viên',
                'alumni': 'Cựu sinh viên',
                'graduate': 'Cựu sinh viên',
                'teacher': 'Giảng viên',
                'lecturer': 'Giảng viên',
                'staff': 'Nhân viên',
                'faculty': 'Khoa',
                'parent': 'Phụ huynh',
                'guest': 'Khách',
                'khách': 'Khách',
                'admin': 'Ban quản trị'
                // thêm mapping nếu cần
            };
            return map[key] || rel;
        }

        function buildCard(w) {
            const card = document.createElement('div');
            card.className = 'wish-card';
            card.dataset.id = w.id;

            const header = document.createElement('div');
            header.className = 'wish-header';

            const avatar = document.createElement('div');
            avatar.className = 'wish-avatar';
            avatar.textContent = (w.name || '') ? (function(name) {
                name = name.trim();
                if (!name) return '??';
                const parts = name.split(/\s+/);
                let letters = '';
                for (let i = 0; i < parts.length && letters.length < 2; i++) {
                    letters += parts[i].substring(0, 1).toUpperCase();
                }
                return letters || '??';
            })(w.name) : '??';

            const info = document.createElement('div');
            info.className = 'wish-info';

            const nameEl = document.createElement('div');
            nameEl.className = 'wish-name';
            nameEl.textContent = w.name ? w.name : 'Bạn ẩn danh';

            const relEl = document.createElement('div');
            relEl.className = 'wish-relationship';
            relEl.innerHTML = '<i class="fas fa-user-graduate"></i> ' + escapeHtml(translateRelationship(w.relationship ? w
                .relationship : 'Khách'));

            const dateEl = document.createElement('div');
            dateEl.className = 'wish-date';
            dateEl.innerHTML = '<i class="far fa-clock"></i> ' + (w.created_at ? escapeHtml(w.created_at_formatted || w
                .created_at) : '');

            info.appendChild(nameEl);
            info.appendChild(relEl);
            info.appendChild(dateEl);

            header.appendChild(avatar);
            header.appendChild(info);

            const msg = document.createElement('div');
            msg.className = 'wish-message';
            // preserve line breaks
            msg.innerHTML = (w.message ? escapeHtml(w.message).replace(/\n/g, '<br>') : '');

            // ĐÃ XÓA PHẦN ACTIONS VÀ LIKE BUTTON

            card.appendChild(header);
            card.appendChild(msg);
            // ĐÃ XÓA card.appendChild(actions);

            return card;
        }

        async function loadMore() {
            if (offset >= total) {
                loadBtn.disabled = true;
                loadBtn.textContent = 'Đã hết lời chúc';
                return;
            }
            loadBtn.disabled = true;
            loadBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Đang tải...';

            try {
                const resp = await fetch('fetch_wishes.php?offset=' + encodeURIComponent(offset) + '&limit=' +
                    encodeURIComponent(pageLimit));
                if (!resp.ok) throw new Error('Network error');
                const data = await resp.json();
                if (!Array.isArray(data.wishes)) throw new Error('Invalid response');

                const grid = document.getElementById('wishGrid');
                // remove "no-wishes" message if present
                const noW = grid.querySelector('.no-wishes');
                if (noW) noW.remove();

                data.wishes.forEach(w => {
                    // format created_at to dd/mm/YYYY on client (server may already provide)
                    if (w.created_at) {
                        const d = new Date(w.created_at);
                        if (!isNaN(d)) {
                            const dd = String(d.getDate()).padStart(2, '0');
                            const mm = String(d.getMonth() + 1).padStart(2, '0');
                            const yy = d.getFullYear();
                            w.created_at_formatted = dd + '/' + mm + '/' + yy;
                        }
                    }
                    const card = buildCard(w);
                    grid.appendChild(card);
                });

                offset += data.wishes.length;
                // update counter display to total (already set by server) - keep consistent
                document.getElementById('wishCount').textContent = total;

                // ĐÃ XÓA bindLikeButtons(grid);

                if (offset >= total) {
                    loadBtn.disabled = true;
                    loadBtn.textContent = 'Đã hết lời chúc';
                } else {
                    loadBtn.disabled = false;
                    loadBtn.innerHTML = '<i class="fas fa-sync-alt"></i> Xem Thêm Lời Chúc';
                }
            } catch (err) {
                console.error(err);
                loadBtn.disabled = false;
                loadBtn.innerHTML = '<i class="fas fa-sync-alt"></i> Thử lại';
                alert('Không thể tải thêm lời chúc. Vui lòng thử lại sau.');
            }
        }

        loadBtn.addEventListener('click', loadMore);

        // hide button if nothing more to load
        if (offset >= total) {
            loadBtn.disabled = true;
            loadBtn.textContent = 'Đã hết lời chúc';
        }
    </script>

    <?php
    // close connection if open
    if (isset($conn) && ($conn instanceof mysqli)) {
        $conn->close();
    }
    ?>
</body>

</html>