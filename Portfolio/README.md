# 🎨 Portfolio Website

Một trang Portfolio hiện đại, đẹp mắt với hiệu ứng glassmorphism, gradient và animations mượt mà.

## ✨ Tính năng

- 🎯 **Responsive Design**: Hoạt động hoàn hảo trên mọi thiết bị (mobile, tablet, desktop)
- 🌈 **Thiết kế hiện đại**: Glassmorphism, gradient đẹp mắt, dark theme
- ⚡ **Animations mượt mà**: Fade-in, slide-up, hover effects
- 📁 **Dynamic Project Loading**: Tự động tải dự án từ thư mục Project
- 🧭 **Smooth Navigation**: Menu điều hướng mượt mà với smooth scroll
- 📱 **Mobile Menu**: Hamburger menu responsive cho thiết bị di động

## 📂 Cấu trúc thư mục

```
Portfolio/
├── index.html          # Trang chính
├── style.css           # CSS với design system
├── script.js           # JavaScript cho tương tác
├── assets/             # Hình ảnh, icons
│   └── (thêm avatar.jpg của bạn vào đây)
└── Project/            # Thư mục chứa các dự án
    └── TamThuGuiNguoiLaiDo/
        └── index.html
```

## 🚀 Cách sử dụng

### 1. Mở trang web
- Mở file `index.html` trong trình duyệt (Chrome, Firefox, Edge)
- Hoặc sử dụng Live Server trong VS Code

### 2. Tùy chỉnh thông tin cá nhân

Mở file `index.html` và chỉnh sửa:

**Thay đổi tên và thông tin:**
```html
<!-- Tìm và sửa phần Hero -->
<h1 class="hero-title">
    <span class="gradient-text">Tên Của Bạn</span>
</h1>
<p class="hero-subtitle">Developer & Creative Designer</p>
<p class="hero-description">
    Viết giới thiệu về bản thân...
</p>
```

**Thay đổi thông tin liên hệ:**
```html
<!-- Tìm section Contact -->
<a href="mailto:your.email@example.com">your.email@example.com</a>
<a href="tel:+84123456789">+84 123 456 789</a>
```

**Thay đổi social links:**
```html
<!-- Sửa các link social media -->
<a href="https://github.com/yourusername" ...>
<a href="https://linkedin.com/in/yourusername" ...>
```

### 3. Thêm Avatar của bạn

1. Chuẩn bị một ảnh đại diện (khuyến nghị: 500x500px, định dạng JPG hoặc PNG)
2. Đặt tên file là `avatar.jpg`
3. Copy vào thư mục `assets/`
4. Mở `index.html` và tìm phần:
```html
<div class="avatar">
    <i class="fas fa-user" style="font-size: 150px; color: rgba(255,255,255,0.3);"></i>
</div>
```
5. Thay thế bằng:
```html
<img src="./assets/avatar.jpg" alt="Avatar" class="avatar">
```

### 4. Thêm dự án mới

**Cách 1: Tự động (khuyến nghị)**

1. Tạo thư mục mới trong `Project/`
   ```
   Project/
   └── TenDuAnMoi/
       ├── index.html
       ├── style.css
       └── ...
   ```

2. Mở file `script.js` và tìm mảng `knownProjects`

3. Thêm thông tin dự án mới:
```javascript
const knownProjects = [
    {
        name: 'Tâm Thư Gửi Người Lái Đò',
        folder: 'TamThuGuiNguoiLaiDo',
        description: 'Một dự án web tương tác đặc biệt...',
        tags: ['HTML', 'CSS', 'JavaScript', 'PHP'],
        image: null,
        link: './Project/TamThuGuiNguoiLaiDo/index.html'
    },
    // THÊM DỰ ÁN MỚI Ở ĐÂY
    {
        name: 'Tên Dự Án Mới',
        folder: 'TenDuAnMoi',
        description: 'Mô tả dự án của bạn',
        tags: ['React', 'Node.js', 'MongoDB'],
        image: './assets/project-thumbnail.jpg', // Tùy chọn
        link: './Project/TenDuAnMoi/index.html'
    }
];
```

4. Làm mới trang (F5) - dự án mới sẽ tự động hiển thị!

## 🎨 Tùy chỉnh màu sắc

Mở `style.css` và sửa đổi CSS variables:

```css
:root {
    /* Màu nền */
    --bg-primary: #0a0a0f;
    --bg-secondary: #1a1a2e;
    
    /* Gradient - Thay đổi màu gradient theo ý bạn */
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    
    /* Màu chữ */
    --text-primary: #ffffff;
    --text-secondary: #b8b8d1;
    --text-accent: #667eea;
}
```

## 📱 Responsive Breakpoints

- **Desktop**: > 968px (hiển thị đầy đủ)
- **Tablet**: 768px - 968px (điều chỉnh layout)
- **Mobile**: < 768px (hamburger menu, stacked layout)

## 🔧 Công nghệ sử dụng

- **HTML5**: Cấu trúc semantic
- **CSS3**: Glassmorphism, Flexbox, Grid, Animations
- **JavaScript (Vanilla)**: Không cần framework
- **Font Awesome**: Icons
- **Google Fonts**: Typography (Inter)

## 💡 Tips

1. **SEO**: Nhớ cập nhật meta tags trong `<head>` của `index.html`
2. **Performance**: Hình ảnh nên được tối ưu (< 500KB)
3. **Browser Support**: Tốt nhất trên Chrome, Firefox, Safari, Edge (phiên bản mới)
4. **Hosting**: Có thể deploy lên GitHub Pages, Netlify, hoặc Vercel miễn phí

## 📸 Screenshots

Mở `index.html` trong trình duyệt để xem kết quả!

## 🤝 Hỗ trợ

Nếu có vấn đề gì, hãy:
1. Kiểm tra Console trong DevTools (F12)
2. Đảm bảo tất cả file đều ở đúng vị trí
3. Kiểm tra đường dẫn file (path) có chính xác không

## 📝 License

Free to use - Customize as you like!

---

Made with ❤️ and ☕
