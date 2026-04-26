-- Database Schema for JP Sport E-commerce
-- Create database first: CREATE DATABASE db_batminton;

USE db_badminton;

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    image VARCHAR(255),
    parent_id INT DEFAULT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    content TEXT,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    sale_price DECIMAL(10,2) DEFAULT NULL,
    quantity INT DEFAULT 0,
    sku VARCHAR(100),
    image VARCHAR(255),
    images JSON,
    featured TINYINT(1) DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_category (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255),
    address TEXT,
    gender VARCHAR(20),
    city VARCHAR(255),
    country VARCHAR(255),
    birthdate DATE,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    status ENUM('active', 'inactive') DEFAULT 'active',
    email_verified_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Posts Table (News/Blog)
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT,
    content TEXT,
    image VARCHAR(255),
    author_id INT,
    category VARCHAR(100) DEFAULT 'news',
    status ENUM('active', 'inactive') DEFAULT 'active',
    featured TINYINT(1) DEFAULT 0,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_number VARCHAR(50) NOT NULL UNIQUE,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255),
    customer_phone VARCHAR(20) NOT NULL,
    customer_address TEXT,
    shipping_address TEXT,
    shipping_city VARCHAR(255),
    shipping_country VARCHAR(255),
    shipping_method VARCHAR(50) DEFAULT 'standard',
    subtotal DECIMAL(10,2) DEFAULT 0,
    total_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    shipping_fee DECIMAL(10,2) DEFAULT 0,
    discount_amount DECIMAL(10,2) DEFAULT 0,
    payment_method ENUM('cod', 'bank_transfer', 'momo', 'vnpay', 'bank', 'card') DEFAULT 'cod',
    payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
    status ENUM('pending', 'processing', 'shipped', 'completed', 'cancelled') DEFAULT 'pending',
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_order_number (order_number),
    INDEX idx_status (status),
    INDEX idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order Items Table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    subtotal DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Settings Table
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Default Admin User (password: admin123)
INSERT INTO users (name, email, phone, password, role, status) 
VALUES ('Admin', 'admin@jpsport.com', '0342826430', '$2y$10$YMjPJqCpNjXHBYJCSeKK7OTcG8/0M3nR0dCFf0pQqKpX8b1PQRGu', 'admin', 'active')
ON DUPLICATE KEY UPDATE name = name;

-- Insert Default Categories
INSERT INTO categories (name, slug, description, status, sort_order) VALUES
('Vợt cầu lông', 'vot-cau-long', 'Các loại vợt cầu lông chính hãng Yonex, Victor, Lining', 'active', 1),
('Giày cầu lông', 'giay-cau-long', 'Giày cầu lông chính hãng các thương hiệu nổi tiếng', 'active', 2),
('Phụ kiện', 'phu-kien', 'Balo, túi vợt, cước, và các phụ kiện cầu lông khác', 'active', 3),
('Quần áo', 'quan-ao', 'Quần áo thể thao cầu lông', 'active', 4),
('Balo cầu lông', 'balo-cau-long', 'Balo, túi đựng vợt chính hãng', 'active', 5)
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- Insert Sample Products
INSERT INTO products (category_id, name, slug, description, price, sale_price, quantity, image, featured, status) VALUES
(1, 'Vợt cầu lông Yonex Arcsaber 11', 'vot-cau-long-yonex-arcsaber-11', 'Vợt cầu lông cao cấp Yonex Arcsaber 11, phù hợp cho người chơi trung cấp và nâng cao', 2500000, 2290000, 50, 'product.jpg', 1, 'active'),
(1, 'Vợt cầu lông Victor Thruster K1', 'vot-cau-long-victor-thruster-k1', 'Vợt cầu lông Victor Thruster K1, công nghệ hiện đại, lực đánh mạnh', 1800000, 1650000, 30, 'product.jpg', 1, 'active'),
(1, 'Vợt cầu lông Lining N80 II', 'vot-cau-long-lining-n80-ii', 'Vợt cầu lông Lining N80 II, tốc độ nhanh, kiểm soát tốt', 2200000, 1990000, 25, 'product.jpg', 1, 'active'),
(1, 'Vợt cầu lông Yonex Nanoflare 800', 'vot-cau-long-yonex-nanoflare-800', 'Vợt cầu lông Yonex Nanoflare 800 với công nghệ mới nhất', 2800000, 2590000, 20, 'product.jpg', 1, 'active'),
(2, 'Giày cầu lông Yonex Power Cushion 65Z3', 'giay-cau-long-yonex-power-cushion-65z3', 'Giày cầu lông Yonex Power Cushion 65Z3, công nghệ đệm tối ưu', 2200000, 1990000, 40, 'product.jpg', 1, 'active'),
(2, 'Giày cầu lông Victor P8500', 'giay-cau-long-victor-p8500', 'Giày cầu lông Victor P8500, êm ái, bám sân tốt', 1800000, 1590000, 35, 'product.jpg', 0, 'active'),
(3, 'Balo Yonex Bao Hồng', 'balo-yonex-bao-hong', 'Balo Yonex chính hãng, đựng vợt và phụ kiện tiện lợi', 800000, 699000, 60, 'product.jpg', 0, 'active'),
(3, 'Cước cầu lông Yonex BG 65', 'cuoc-cau-long-yonex-bg-65', 'Cước cầu lông Yonex BG 65, độ bền cao, phù hợp mọi lực đánh', 60000, 50000, 200, 'product.jpg', 0, 'active')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- Insert Sample News
INSERT INTO posts (title, slug, excerpt, content, category, status, featured) VALUES
('Hướng dẫn chọn vợt cầu lông phù hợp', 'huong-dan-chon-vot-cau-long', 'Hướng dẫn chi tiết cách chọn vợt cầu lông phù hợp với phong cách chơi của bạn', 'Nội dung chi tiết về cách chọn vợt...', 'news', 'active', 1),
('Top 5 vợt cầu lông hot nhất 2024', 'top-5-vot-cau-long-hot-nhat-2024', 'Khám phá top 5 vợt cầu lông được yêu thích nhất năm 2024', 'Danh sách top 5 vợt cầu lông...', 'news', 'active', 1),
('Kỹ thuật cầu lông cơ bản cho người mới', 'ki-thuat-cau-long-co-ban', 'Hướng dẫn các kỹ thuật cầu lông cơ bản dành cho người mới bắt đầu', 'Các kỹ thuật cơ bản...', 'news', 'active', 0)
ON DUPLICATE KEY UPDATE title = VALUES(title);

-- Insert Default Settings
INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'JP SPORT'),
('site_email', 'contact@jpsport.com'),
('site_phone', '0342826430'),
('site_address', '123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh'),
('site_logo', ''),
('facebook', 'https://facebook.com/jpsport'),
('instagram', 'https://instagram.com/jpsport'),
('shipping_fee', '30000'),
('free_shipping', '500000')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);

-- Guide Categories Table
CREATE TABLE IF NOT EXISTS guide_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Guide Contents Table
CREATE TABLE IF NOT EXISTS guide_contents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES guide_categories(id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample guide categories
INSERT INTO guide_categories (name, description) VALUES
('Hướng dẫn mua hàng', 'Các bước hướng dẫn mua hàng trên website'),
('Hướng dẫn thanh toán', 'Thông tin về các phương thức thanh toán'),
('Chính sách vận chuyển', 'Quy định về giao hàng và vận chuyển'),
('Chính sách đổi trả', 'Quy định về đổi trả sản phẩm')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- Insert sample guide contents
INSERT INTO guide_contents (category_id, title, slug, content) VALUES
(1, 'Cách đặt hàng trên website', 'cach-dat-hang-tren-website', '<p>Để đặt hàng trên website JP Sport, bạn thực hiện các bước sau:</p><ol><li>Chọn sản phẩm cần mua</li><li>Thêm vào giỏ hàng</li><li>Vào giỏ hàng và tiến hành thanh toán</li><li>Điền thông tin giao hàng</li><li>Chọn phương thức thanh toán</li><li>Xác nhận đơn hàng</li></ol>'),
(1, 'Hướng dẫn chọn size vợt cầu lông', 'huong-dan-chon-size-vot-cau-long', '<p>Việc chọn vợt cầu lông phù hợp rất quan trọng. Bạn cần xem xét trọng lượng vợt, điểm cân bằng, độ cứng thân vợt và lực căng dây.</p>'),
(2, 'Các phương thức thanh toán', 'cac-phuong-thuc-thanh-toan', '<p>JP Sport hỗ trợ các phương thức thanh toán: COD (thanh toán khi nhận hàng), chuyển khoản ngân hàng, ví MoMo và thẻ tín dụng.</p>'),
(3, 'Thờigian giao hàng', 'thoi-gian-giao-hang', '<p>Thờigian giao hàng dự kiến từ 2-5 ngày làm việc tùy khu vực. Đơn hàng nội thành HCM thường giao trong 1-2 ngày.</p>'),
(4, 'Quy định đổi trả trong 7 ngày', 'quy-dinh-doi-tra-trong-7-ngay', '<p>Sản phẩm được đổi trả trong vòng 7 ngày kể từ ngày nhận hàng. Sản phẩm phải còn nguyên tem mác, chưa qua sử dụng và có hóa đơn mua hàng.</p>')
ON DUPLICATE KEY UPDATE title = VALUES(title);
