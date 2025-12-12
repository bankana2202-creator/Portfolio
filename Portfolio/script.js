// ==================== Navigation ====================
const navbar = document.querySelector('.navbar');
const navToggle = document.getElementById('navToggle');
const navMenu = document.querySelector('.nav-menu');
const navLinks = document.querySelectorAll('.nav-link');

// Navbar scroll effect
window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Mobile menu toggle
navToggle.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    navToggle.classList.toggle('active');
});

// Close mobile menu when clicking on a link
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        navMenu.classList.remove('active');
        navToggle.classList.remove('active');
    });
});

// ==================== Smooth Scroll ====================
navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = link.getAttribute('href');
        const targetSection = document.querySelector(targetId);
        
        if (targetSection) {
            const offsetTop = targetSection.offsetTop - 80;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    });
});

// ==================== Scroll Animations ====================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, observerOptions);

// Observe all fade-in elements
document.querySelectorAll('.fade-in').forEach(element => {
    observer.observe(element);
});

// ==================== Dynamic Project Loading ====================

// Project data structure
const projectsData = [];

// Known projects configuration
const knownProjects = [
    {
        name: 'Tâm Thư Gửi Người Lái Đò',
        folder: 'TamThuGuiNguoiLaiDo',
        description: 'Một dự án web tương tác để các bạn sinh viên có thể gửi những lời chúc của mình đến cho những người lái đò.',
        tags: ['HTML', 'CSS', 'JavaScript', 'PHP'],
        image: './Project/TamThuGuiNguoiLaiDo/image/banner_goc.jpg',
        link: './Project/TamThuGuiNguoiLaiDo/index.php',
        github: 'https://github.com/bankana2202-creator/TamThuGuiNguoiLaiDo'
    }
    // Add more projects here as you create them
];

// Load projects from the Project folder
async function loadProjects() {
    const projectsGrid = document.getElementById('projectsGrid');
    
    try {
        // Since we can't directly access the file system from JavaScript in the browser,
        // we'll need to manually define the projects here.
        // In a real-world scenario, this would be loaded from a backend API or JSON file.
        projectsGrid.innerHTML = '';
        
        // If no projects found
        if (knownProjects.length === 0) {
            projectsGrid.innerHTML = `
                <div class="project-card">
                    <div class="project-content">
                        <h3 class="project-title">Chưa có dự án nào</h3>
                        <p class="project-description">Các dự án sẽ được cập nhật sớm!</p>
                    </div>
                </div>
            `;
            return;
        }
        
        // Render projects
        knownProjects.forEach((project, index) => {
            const projectCard = createProjectCard(project, index);
            projectsGrid.appendChild(projectCard);
        });
        
        // Re-observe new elements for animation
        document.querySelectorAll('.project-card').forEach(element => {
            observer.observe(element);
        });
        
    } catch (error) {
        console.error('Error loading projects:', error);
        projectsGrid.innerHTML = `
            <div class="project-card">
                <div class="project-content">
                    <h3 class="project-title">Lỗi tải dự án</h3>
                    <p class="project-description">Vui lòng thử lại sau</p>
                </div>
            </div>
        `;
    }
}

// Create project card HTML
function createProjectCard(project, index) {
    const card = document.createElement('div');
    card.className = 'project-card fade-in';
    card.style.animationDelay = `${index * 0.1}s`;
    
    // Generate gradient based on project index
    const gradients = [
        'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
        'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
        'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
        'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
    ];
    const gradient = gradients[index % gradients.length];
    
    card.innerHTML = `
        <div class="project-image" style="background: ${gradient}">
            ${project.image ? `<img src="${project.image}" alt="${project.name}">` : `<i class="fas fa-code"></i>`}
        </div>
        <div class="project-content">
            <h3 class="project-title">${project.name}</h3>
            <p class="project-description">${project.description}</p>
            <div class="project-tags">
                ${project.tags.map(tag => `<span class="project-tag">${tag}</span>`).join('')}
            </div>
            <div class="project-links">
                <a href="${project.link}" class="project-link project-link-primary" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Xem demo
                </a>
                ${project.github ? `<a href="${project.github}" class="project-link project-link-secondary" target="_blank">
                    <i class="fab fa-github"></i> GitHub
                </a>` : `<a href="${project.link}" class="project-link project-link-secondary" target="_blank">
                    <i class="fas fa-folder-open"></i> Chi tiết
                </a>`}
            </div>
        </div>
    `;
    
    
    return card;
}

// Auto-scan for new projects (advanced feature)
// This function would need a backend to work properly
async function scanProjectFolder() {
    // This is a placeholder for future implementation
    // In a real scenario, you'd have a backend API that scans the Project folder
    // and returns a list of all projects with their metadata
    
    // Example implementation would look like:
    // const response = await fetch('/api/projects');
    // const projects = await response.json();
    // return projects;
    
    return [];
}

// ==================== Helper Functions ====================

// Format project name from folder name
function formatProjectName(folderName) {
    return folderName
        .replace(/([A-Z])/g, ' $1')
        .replace(/^./, str => str.toUpperCase())
        .trim();
}

// ==================== Initialize ====================
document.addEventListener('DOMContentLoaded', () => {
    // Load projects on page load
    loadProjects();
    
    // Add active state to nav links on scroll
    const sections = document.querySelectorAll('.section, .hero');
    
    window.addEventListener('scroll', () => {
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (window.scrollY >= sectionTop - 200) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
});

// ==================== Add More Projects Dynamically ====================

/**
 * HOW TO ADD MORE PROJECTS:
 * 
 * 1. Create a new folder in the "Project" directory
 * 2. Add your project files including an index.html or index.php
 * 3. Add the project information to the knownProjects array in the loadProjects() function
 * 
 * Example:
 * {
 *     name: 'My Awesome Project',
 *     folder: 'MyAwesomeProject',
 *     description: 'A description of what this project does',
 *     tags: ['React', 'Node.js', 'MongoDB'],
 *     image: './assets/project-thumbnail.jpg', // Optional
 *     link: './Project/MyAwesomeProject/index.html'
 * }
 * 
 * The page will automatically refresh and display your new project!
 */

// ==================== Chatbox Functionality ====================
// Wait for DOM to be fully loaded including chatbox elements
window.addEventListener('load', function() {
    const chatbox = document.getElementById('chatbox');
    const chatboxToggle = document.getElementById('chatboxToggle');
    const chatboxClose = document.getElementById('chatboxClose');
    const chatMessages = document.getElementById('chatMessages');
    const chatInput = document.getElementById('chatInput');
    const chatSend = document.getElementById('chatSend');

    // Check if elements exist
    if (!chatbox || !chatboxToggle) {
        console.error('Chatbox elements not found');
        return;
    }

    // Bot avatar path
    const botAvatar = './Project/TamThuGuiNguoiLaiDo/image/favicon2.png';

    // Toggle chatbox
chatboxToggle.addEventListener('click', () => {
    chatbox.classList.toggle('active');
    chatboxToggle.classList.toggle('active');
    if (chatbox.classList.contains('active')) {
        chatInput.focus();
    }
});

// Close chatbox
chatboxClose.addEventListener('click', () => {
    chatbox.classList.remove('active');
    chatboxToggle.classList.remove('active');
});

// Send message on Enter key
chatInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
});

// Send message on button click
chatSend.addEventListener('click', sendMessage);

// Send message function
async function sendMessage() {
    const message = chatInput.value.trim();
    if (!message) return;

    // Disable input while processing
    chatInput.disabled = true;
    chatSend.disabled = true;

    // Add user message to chat
    addMessage(message, 'user');
    chatInput.value = '';

    // Show typing indicator
    const typingIndicator = showTypingIndicator();

    try {
        // Send request to backend
        const response = await fetch('./chatbot/chat.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ message: message })
        });

        // Remove typing indicator
        typingIndicator.remove();

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        if (data.success) {
            addMessage(data.message, 'bot');
        } else {
            addMessage('Xin loi, da co loi xay ra. Vui long thu lai sau.', 'bot');
        }
    } catch (error) {
        console.error('Chat error:', error);
        typingIndicator.remove();
        addMessage('Khong the ket noi den server. Vui long thu lai sau.', 'bot');
    }

    // Re-enable input
    chatInput.disabled = false;
    chatSend.disabled = false;
    chatInput.focus();
}

// Add message to chat
function addMessage(text, sender) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'chat-message ' + (sender === 'user' ? 'user-message' : 'bot-message');

    if (sender === 'bot') {
        messageDiv.innerHTML = 
            '<img src=\"' + botAvatar + '\" alt=\"Bot\" class=\"message-avatar\">' +
            '<div class=\"message-content\"><p>' + escapeHtml(text) + '</p></div>';
    } else {
        messageDiv.innerHTML = 
            '<div class=\"message-content\"><p>' + escapeHtml(text) + '</p></div>';
    }

    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Show typing indicator
function showTypingIndicator() {
    const typingDiv = document.createElement('div');
    typingDiv.className = 'chat-message bot-message';
    typingDiv.innerHTML = 
        '<img src=\"' + botAvatar + '\" alt=\"Bot\" class=\"message-avatar\">' +
        '<div class=\"typing-indicator\"><span></span><span></span><span></span></div>';
    chatMessages.appendChild(typingDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
    return typingDiv;
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
}); // End of window.addEventListener('load')
