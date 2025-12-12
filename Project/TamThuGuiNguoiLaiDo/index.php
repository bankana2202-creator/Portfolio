<?php

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="image/favicon.png">
    <link rel="stylesheet" href="style.css" />
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
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Mừng Kỉ Niệm 30 Năm Thành Lập Trường & 20/11</title>
</head>

<body>
    <nav id="navbar">
        <div class="nav-container">
            <div class="nav-main">
                <div class="nav-left">
                    <a href="#home" class="nav-logo">
                        <img src="image/logo.png" alt="Logo Trường Đại học Hùng Vương TP.HCM" />
                    </a>
                    <ul class="nav-menu">
                        <li><a href="#home"><i class="fas fa-home"></i> Trang Chủ</a></li>
                        <li><a href="#section2"><i class="fas fa-road"></i> Cột Mốc Lịch Sử</a></li>
                        <li><a href="#section3"><i class="fas fa-images"></i> Khoảnh Khắc Đáng Nhớ</a></li>
                        <li><a href="#section4"><i class="fas fa-heart"></i> Lời Tri Ân</a></li>
                        <li><a href="#section5"><i class="fas fa-envelope"></i> Gửi Lời Chúc</a></li>
                    </ul>
                </div>
            </div>

            <!-- Wish Ticker - trên dòng riêng -->
            <div class="wish-ticker-container">
                <div class="wish-ticker" id="wishTicker" aria-live="polite">
                    <span class="ticker-item">Chưa có lời chúc nào — hãy gửi lời chúc đầu tiên!</span>
                </div>
            </div>
        </div>
    </nav>

    <script>
        window.__WISHES = [];
    </script>

    <?php
    // load lời chúc từ DB
    $wishes = [];
    try {
        require_once 'connect.php';
        if ($conn) {
            $res = $conn->query("SELECT name, message FROM wishes ORDER BY created_at DESC LIMIT 50");
            if ($res) {
                while ($r = $res->fetch_assoc()) {
                    $wishes[] = [
                        'name' => $r['name'] && trim($r['name']) !== '' ? $r['name'] : null,
                        'message' => $r['message']
                    ];
                }
                $res->free();
            }
        }
    } catch (\Throwable $e) {
    }
    ?>
    <!-- chuyển data từ php sang js -->
    <script>
        window.__WISHES =
            <?php echo json_encode($wishes, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    </script>

    <!-- Home Section - Để trống -->
    <div id="home" class="hero">
        <img src="./image/banner_goc.jpg" alt="">
    </div>



    <!-- Main Content -->
    <div class="container">
        <!-- Cột Mốc Lịch Sử Section -->
        <section id="section2">
            <h2><i class="fas fa-road"></i> Cột Mốc Lịch Sử</h2>
            <div class="timeline">
                <div class="milestone">
                    <p>◆ Ngày 03/11/1993, Bộ Giáo dục và Đào tạo ra quyết định số 2395/QĐ-TCCB, chính thức công nhận
                        Hội
                        đồng Sáng lập Trường Đại học Dân lập Hùng Vương Thành phố Hồ Chí Minh. Hội đồng Sáng lập trường
                        gồm 9 thành viên, trong đó cố Giáo sư, Thạc sĩ Y khoa Ngô Gia Hy giữ vai trò chủ tịch. Đây là
                        cột
                        mốc đầu tiên, đánh dấu sự ra đời của ngôi trường mang tên Quốc tổ Vua Hùng.</p>
                    <p>◆ Ngày 14/08/1995, Thủ tướng Chính phủ ký quyết định số 470-TTg cho phép thành lập Trường Đại
                        học Dân lập Hùng Vương Thành phố Hồ Chí Minh. Trong giai đoạn này, Trường xây dựng tôn chỉ:
                        "Khoa
                        học - Phát triển - Đạo đức" với phương châm: Chất lượng hàng đầu, không chạy theo số lượng,
                        không vụ
                        lợi cá nhân, trong sáng về tài chính.</p>
                </div>
                <div class="milestone">
                    <p>◆ Logo đầu tiên của Trường chính thức ra mắt vào Ngày truyền thống lần thứ nhất - ngày 9/3/1996
                        (âm lịch). Logo mang nhiều biểu tượng giàu ý nghĩa. Hình ảnh chiếc vạc ba chân ở trung tâm
                        tượng
                        trưng cho tam tài: thiên, địa, nhân. Sự kết hợp giữa hình vuông và hình tròn gợi nhắc bánh
                        chưng
                        và
                        bánh dày, biểu trưng cho đất và trời, đồng thời đại diện cho cha và mẹ, âm và dương, thể hiện
                        triết
                        lý "vuông tròn" đậm nét văn hóa Việt Nam.</p>
                    <div>
                        <img src="./image/lg1.png" alt="">
                    </div>
                </div>
                <div class="milestone">
                    <p>◆ Ngày 14/05/2008, Bộ trưởng Bộ Giáo dục và Đào tạo ban hành văn bản số 4167/BGDĐT-PC cho phép
                        Trường Đại học Dân lập Hùng Vương đổi tên thành Trường Đại học Hùng Vương Thành phố Hồ Chí Minh
                    </p>
                    <p>◆ Vào ngày 19/05/2010, Trường Đại học Hùng Vương Thành phố Hồ Chí Minh (DHV) mở ra một bước
                        ngoặt lớn khi được Thủ tướng Chính phủ phê duyệt chuyển đổi từ loại hình dân lập sang tư thục.
                        Đây
                        không chỉ là sự chuyển mình về pháp lý mà còn là bước chuyển về chất lượng đào tạo và quản lý,
                        mở ra
                        một giai đoạn phát triển mới, bền vững hơn cho nhà trường</p>
                </div>
                <div class="milestone">
                    <p>◆ Ngày 05/04/2017, Trường Đại học Hùng Vương Thành phố Hồ Chí Minh (DHV) ra mắt bộ nhận diện
                        thương hiệu mới - HVUH với slogan "Đồng hành cùng bạn, kiến tạo tương lai"</p>
                    <div> <img src="./image/lg2.png" alt="">
                    </div>
                </div>
                <div class="milestone">
                    <p>◆ Vào ngày 14/11/2023, trải qua đại dịch Covid-19 với nhiều ảnh hưởng sâu rộng, Ban lãnh đạo nhà
                        trường sau nhiều phiên họp đã đưa ra những đường lối, định hướng phát triển mới cho trường đồng
                        thời công bố bộ nhận diện thương hiệu và biểu tượng mới - DHV.</p>
                    <div> <img src="./image/lg3.png" alt="">
                    </div>
                </div>
                <div class="milestone">
                    <p>◆ Sau gần 30 năm hình thành và phát triển, hiện nay, Trường Đại học Hùng Vương Thành Phố Hồ Chí
                        Minh (DHV) đang chú trọng đổi mới nâng cao chất lượng đào tạo theo xu hướng hiện đại, đưa công
                        nghệ
                        vào trường học (VR Center, AJ Job, LMS…) phục vụ cho việc học tập, nghiên cứu của sinh viên và
                        giảng viên. Đồng thời Trường cũng chủ động hợp tác mở rộng mối quan hệ với các doanh nghiệp,
                        tạo
                        ra
                        hệ sinh thái vệ tinh cho sinh viên đi kiến tập, thực tập đảm bảo sinh viên được trang bị kiến
                        thức
                        chuyên môn lẫn kỹ năng thực tế, đáp ứng yêu cầu về nguồn nhân lực chất lượng cao trong kỷ
                        nguyên số, hướng đến mục tiêu trở thành Trường đại học thông minh, đổi mới sáng tạo và khởi
                        nghiệp.
                    </p>
                </div>
            </div>
        </section>

        <!-- Khoảnh Khắc Đáng Nhớ Section -->

        <section id="section3">
            <h2><i class="fas fa-images"></i> Khoảnh Khắc Đáng Nhớ</h2>
            <p>Những hình ảnh đẹp trong hành trình 30 năm xây dựng và phát triển của Trường Đại học Hùng Vương TP.HCM.
            </p>

            <div class="gallery">
                <div class="gallery-item">
                    <a href="https://www.facebook.com/share/p/1FG8w7riZS/" target="_blank">
                        <img src="./image/CT_MOC.jpg" alt="">
                    </a>
                    <div class="gallery-caption">
                        CHUNG KẾT “MEMORIES ON CARDS” – MỖI TẤM THẺ, MỘT KHOẢNH KHẮC ĐÁNG NHỚ
                    </div>
                </div>

                <div class="gallery-item">
                    <a href="https://www.facebook.com/share/p/14JyesA9EWE/" target="_blank">
                        <img src="./image/CB_AI.jpg" alt="">
                    </a>
                    <div class="gallery-caption">
                        HỘI THẢO CÔNG BỐ MỞ NGÀNH ĐÀO TẠO TRÍ TUỆ NHÂN TẠO (AI)
                    </div>
                </div>

                <div class="gallery-item">
                    <a href="https://www.facebook.com/share/p/1FmjobUjzk/" target="_blank">
                        <img src="./image/YNBB.jpg" alt="">
                    </a>
                    <div class="gallery-caption">
                        Sự kiện Sinh hoạt công dân - sinh viên đầu khoa </div>
                </div>
                <div class="gallery-item">
                    <a href="https://www.facebook.com/share/p/179cikUs1o/" target="_blank">
                        <img src="./image/20_11.jpg" alt="">
                    </a>
                    <div class="gallery-caption">
                        HÀNH TRÌNH TRI ÂN NGÀY NHÀ GIÁO VIỆT NAM 20/11 TẠI DHV </div>
                </div>
                <div class="gallery-item">
                    <a href="https://www.facebook.com/share/p/19udESm29n/" target="_blank">
                        <img src="./image/29Y.jpg" alt="">
                    </a>
                    <div class="gallery-caption">
                        LỄ KỶ NIỆM 29 NĂM THÀNH LẬP TRƯỜNG ĐẠI HỌC HÙNG VƯƠNG TP.HCM </div>
                </div>
                <div class="gallery-item">
                    <a href="https://www.facebook.com/share/p/1D2d3bVKNP/" target="_blank">
                        <img src="./image/QT.jpg" alt="">
                    </a>
                    <div class="gallery-caption">
                        DHV VÀ CHƯƠNG TRÌNH HỢP TÁC QUỐC TẾ </div>
                </div>
            </div>
        </section>



        <!-- Lời Tri Ân Section -->
        <section id="section4">
            <h2><i class="fas fa-heart"></i> Lời Tri Ân</h2>
            <p>Ba mươi năm – một hành trình của tâm huyết, tri thức và tình người.
                Nhân dịp kỷ niệm 30 năm thành lập, chúng tôi xin gửi lời tri ân sâu sắc đến Ban Giám hiệu, quý thầy cô,
                cán bộ – nhân viên cùng toàn thể các thế hệ sinh viên đã chung tay viết nên câu chuyện đẹp mang tên
                Trường Đại học Hùng Vương TP. Hồ Chí Minh.
            </p>

            <div class="tribute-cards">
                <div class="tribute-card">
                    <i class="fas fa-user-tie"></i>
                    <h3>Tri ân Ban Giám hiệu</h3>
                    <p>Xin gửi lời cảm ơn chân thành đến các thế hệ lãnh đạo nhà trường – những người đã chèo lái con
                        thuyền tri thức qua biết bao sóng gió, đặt nền móng và không ngừng vun đắp để Hùng Vương hôm nay
                        trở thành mái trường vững vàng, tự hào và đầy khát vọng.</p>
                </div>
                <div class="tribute-card">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <h3>Tri ân Giảng viên</h3>
                    <p>Xin được cúi đầu tri ân những người thầy, người cô đã lặng lẽ cống hiến cả tuổi trẻ và đam mê cho
                        sự nghiệp trồng người. Từng bài giảng, từng lời chỉ dạy đã gieo mầm tri thức và thắp sáng ước mơ
                        cho bao thế hệ sinh viên vươn xa.</p>
                </div>
                <div class="tribute-card">
                    <i class="fas fa-user-graduate"></i>
                    <h3>Tri ân Cựu sinh viên</h3>
                    <p>Xin gửi lời cảm ơn chân thành đến các anh chị cựu sinh viên – những người đã và đang lan tỏa tinh
                        thần Hùng Vương trong từng bước đi, từng thành công. Chính các anh chị là niềm tự hào, là minh
                        chứng sống động cho giá trị và bản lĩnh của ngôi trường thân yêu này.</p>
                </div>
            </div>
        </section>

        <!-- Gửi Lời Chúc Section -->
        <section id="section5">
            <h2><i class="fas fa-envelope"></i> Gửi Lời Chúc Đến Trường</h2>
            <p>Hãy chia sẻ những kỷ niệm, lời chúc mừng hoặc cảm nghĩ của bạn về Trường Đại học Hùng Vương TP.HCM nhân
                dịp kỷ niệm 30 năm thành lập.</p>
            <form id="wishForm" action="submit_wish.php" method="POST">
                <div class="message-form">
                    <div class="form-group">
                        <label for="name"><i class="fas fa-user"></i> Họ và tên:</label>
                        <input type="text" id="name" name="name" maxlength="100" placeholder="Nhập họ và tên của bạn">
                    </div>

                    <div class="form-group">
                        <label for="relationship"><i class="fas fa-link"></i> Mối quan hệ với trường:</label>
                        <select id="relationship" name="relationship">
                            <option value="">-- Chọn mối quan hệ --</option>
                            <option value="student">Sinh viên hiện tại</option>
                            <option value="alumni">Cựu sinh viên</option>
                            <option value="lecturer">Giảng viên/Cán bộ</option>
                            <option value="parent">Phụ huynh</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message"><i class="fas fa-comment"></i> Lời chúc / Kỷ niệm:</label>
                        <textarea id="message" name="message" required maxlength="10000"
                            placeholder="Hãy viết lời chúc hoặc chia sẻ kỉ niệm của bạn với trường ..."></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit"><i class="fas fa-paper-plane"></i> Xác nhận</button>
                    </div>
                </div>
            </form>
        </section>
        <!-- Hiển thị thông báo khi gửi thành công hoạc bị chặn -->
        <?php if (isset($_GET['success']) && $_GET['success'] === '1'): ?>
            <p class="success">Lời gửi gắm của bạn đã đến được các giáo viên. Cảm ơn và chúc bạn ngày tốt lành!</p>
        <?php endif; ?>
        <?php if (isset($_GET['blocked']) && $_GET['blocked'] === '1'): ?>
            <p class="error">Dừng lại đi, Hãy trưởng thành hơn bạn trẻ nhé.</p>
        <?php endif; ?>
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
                    <li><i class="fas fa-chevron-right"></i> <a href="#home">Trang Chủ</a></li>
                    <li><i class="fas fa-chevron-right"></i> <a href="#section2">Cột Mốc Lịch Sử</a></li>
                    <li><i class="fas fa-chevron-right"></i> <a href="#section3">Khoảnh Khắc Đáng Nhớ</a></li>
                    <li><i class="fas fa-chevron-right"></i> <a href="#section4">Lời Tri Ân</a></li>
                    <li><i class="fas fa-chevron-right"></i> <a href="#section5">Gửi Lời Chúc</a></li>
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
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 - Chào mừng kỷ niệm 30 năm thành lập Trường Đại học Hùng Vương TP.HCM & kỷ niệm 42 năm Ngày
                Nhà giáo Việt Nam</p>
            <p>Đây là sản phẩm cá nhân, không phải website chính thức của trường !</p>
        </div>
    </footer>


    <!-- Modal -->
    <div id="modalOverlay" class="modal-overlay" aria-hidden="true">
        <div class="modal" role="dialog" aria-modal="true">
            <h3 id="modalTitle">Thông báo</h3>
            <p id="modalMessage"></p>
            <div>
                <button id="modalOk" class="btn">OK</button>
            </div>
        </div>
    </div>

    <!-- Back to top button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Khởi động AOS
        AOS.init({
            duration: 1200,
            once: true,
        });

        // Navbar cố định khi cuộn
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

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

        // Smooth scroll cho navigation
        document.querySelectorAll('nav a, .footer-section a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Modal helper
        (function() {
            const overlay = document.getElementById('modalOverlay');
            const titleEl = document.getElementById('modalTitle');
            const msgEl = document.getElementById('modalMessage');
            const ok = document.getElementById('modalOk');

            function showModal(title, message) {
                titleEl.textContent = title;
                msgEl.textContent = message;
                overlay.classList.add('show');
                overlay.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                overlay.classList.remove('show');
                overlay.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }

            ok.addEventListener('click', closeModal);
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) closeModal();
            });

            // Form submission via AJAX (keeps submit_wish.php behavior)
            const form = document.getElementById('wishForm');
            if (form) {
                form.addEventListener('submit', function(ev) {
                    ev.preventDefault();

                    const name = form.querySelector('#name').value.trim();
                    const relationship = form.querySelector('#relationship').value.trim();
                    const message = form.querySelector('#message').value.trim();

                    // Chỉ yêu cầu message, các trường khác là tuỳ chọn
                    if (!message) {
                        showModal('Lỗi', 'Vui lòng nhập lời chúc trước khi gửi!');
                        return;
                    }

                    const formData = new FormData(form);
                    showModal('Đang gửi', 'Đang gửi lời chúc...');

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(r => r.json()).then(data => {
                        if (data && data.status === 'success') {
                            showModal('Thành công',
                                'Cảm ơn bạn đã gửi lời chúc! Lời chúc của bạn đã được ghi nhận.');
                            form.reset();
                        } else if (data && data.status === 'blocked') {
                            showModal('Bị chặn', data.message || 'Nội dung chứa từ ngữ không phù hợp.');
                        } else {
                            showModal('Lỗi', (data && data.message) ? data.message :
                                'Đã có lỗi xảy ra. Vui lòng thử lại sau.');
                        }
                    }).catch(() => {
                        showModal('Lỗi', 'Không thể kết nối tới máy chủ. Vui lòng thử lại.');
                    });
                });
            }
        })();

        // Marquee-style wish ticker
        (function() {
            const tickEl = document.getElementById('wishTicker');
            const wishes = Array.isArray(window.__WISHES) ? window.__WISHES : [];
            if (!tickEl) return;

            function renderWishText(w) {
                return (w.name ? (w.name + ': ') : '') + w.message;
            }

            // Build items array (at least one placeholder)
            const items = wishes.length ? wishes.map(renderWishText) : [
                'Chưa có lời chúc nào — hãy gửi lời chúc đầu tiên!'
            ];

            // Create a track element and populate with items separated by ' | '
            function buildTrack() {
                const track = document.createElement('div');
                track.className = 'ticker-track';

                items.forEach((txt, i) => {
                    const span = document.createElement('span');
                    span.className = 'ticker-item';
                    span.textContent = txt;
                    track.appendChild(span);

                    // separator except after last
                    if (i !== items.length - 1) {
                        const sep = document.createElement('span');
                        sep.className = 'ticker-sep';
                        sep.textContent = ' | ';
                        track.appendChild(sep);
                    }
                });

                return track;
            }

            // Build two copies for seamless loop
            const trackA = buildTrack();
            const trackB = buildTrack();
            tickEl.innerHTML = '';
            tickEl.appendChild(trackA);
            tickEl.appendChild(trackB);

            // After DOM paints, measure width and set animation duration
            requestAnimationFrame(() => {
                const totalWidth = trackA.getBoundingClientRect().width;
                // base speed: 80 pixels per second (tweakable)
                const speed = 80; // px/s
                const duration = Math.max(8, Math.round((totalWidth / speed))); // seconds
                // set CSS variable on track container
                trackA.style.setProperty('--marquee-duration', duration + 's');
                trackB.style.setProperty('--marquee-duration', duration + 's');
                // apply animate class
                trackA.classList.add('animate');
                trackB.classList.add('animate');
            });
        })();
    </script>
</body>

</html>

</html>