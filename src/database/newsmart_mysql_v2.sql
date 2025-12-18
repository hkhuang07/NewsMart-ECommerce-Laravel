-- 1. TẠO DATABASE
CREATE DATABASE IF NOT EXISTS NewsMartDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Sử dụng database
USE NewsMartDB;

-- 2. TẠO CÁC BẢNG PHỤ TRỢ (Lookup Tables)
-- Bảng Roles: Định nghĩa các vai trò người dùng trong hệ thống (Admin, Product Manager, Content Editor, Saler, Shipper, User/Customer)
CREATE TABLE Roles (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Description TEXT,
    UNIQUE KEY (Name(191))
);

-- Bảng OrderStatuses: Các trạng thái của đơn hàng (Pending, Confirmed, Preparing, Shipping, Delivered, Cancelled)
CREATE TABLE OrderStatuses (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Description TEXT,
    UNIQUE KEY (Name(191))
);

-- Bảng Topics: Các chủ đề cho bài viết (ví dụ: Tin tức, Khuyến mãi, Hướng dẫn)
CREATE TABLE Topics (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Slug VARCHAR(191) NOT NULL UNIQUE, -- Đã sửa độ dài Slug
    Description TEXT,
    UNIQUE KEY (Name(191))
);

-- Bảng PostTypes: Các loại bài viết (ví dụ: Article, News, Blog Post, Product Review)
CREATE TABLE PostTypes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Slug VARCHAR(191) NOT NULL UNIQUE, -- Đã sửa độ dài Slug
    Description TEXT,
    UNIQUE KEY (Name(191))
);

-- 3. TẠO VÀ NÂNG CẤP CÁC BẢNG CHÍNH

-- Bảng Users: Lưu trữ thông tin tất cả người dùng
CREATE TABLE Users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(255) NOT NULL,
    Username VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    RoleID INT NOT NULL, -- RoleID là bắt buộc để xác định quyền
    IsActive BOOLEAN DEFAULT TRUE, -- Trạng thái kích hoạt tài khoản
    Address VARCHAR(255),
    Phone VARCHAR(20),
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY (Username(191)),
    UNIQUE KEY (Email(191))
);

-- Bảng Categories: Danh mục sản phẩm
CREATE TABLE Categories (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Slug VARCHAR(191) NOT NULL UNIQUE, -- Đã sửa độ dài Slug
    Description TEXT,
    ParentID INT, -- Hỗ trợ danh mục cha-con
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY (Name(191))
);

-- Bảng Brands: Thương hiệu sản phẩm
CREATE TABLE Brands (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Slug VARCHAR(191) NOT NULL UNIQUE, -- Đã sửa độ dài Slug
    Address VARCHAR(255),
    Email VARCHAR(255),
    Contact VARCHAR(50),
    Description TEXT,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY (Name(191))
);

-- Bảng Products: Thông tin chi tiết về sản phẩm
CREATE TABLE Products (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    CategoryID INT NOT NULL,
    BrandID INT NOT NULL,
    SalerID INT NOT NULL, -- Liên kết sản phẩm với Saler tạo ra nó
    Name VARCHAR(255) NOT NULL,
    Slug VARCHAR(191) NOT NULL UNIQUE, -- Đã sửa độ dài Slug
    SKU VARCHAR(50) UNIQUE, -- Thêm SKU cho quản lý tồn kho và sản phẩm
    Description TEXT,
    Price DECIMAL(18, 2) NOT NULL,
    StockQuantity INT NOT NULL DEFAULT 0,
    Discount DECIMAL(5, 2) DEFAULT 0.00,
    AverageRate DECIMAL(2, 1) DEFAULT 0.0,
    Favorites INT DEFAULT 0,
    Purchases INT DEFAULT 0,
    Views INT DEFAULT 0,
    IsActive BOOLEAN DEFAULT TRUE, -- Trạng thái hiển thị sản phẩm
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng ProductImages: Hình ảnh của sản phẩm
CREATE TABLE ProductImages (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ProductID INT NOT NULL,
    URL VARCHAR(255) NOT NULL,
    IsMainImage BOOLEAN DEFAULT FALSE,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng Orders: Thông tin về đơn hàng (Mỗi đơn hàng chỉ từ 1 Saler)
CREATE TABLE Orders (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    SalerID INT NOT NULL, -- Đảm bảo mỗi đơn hàng liên kết với MỘT Saler
    OrderDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    OrderStatusID INT NOT NULL,
    TotalAmount DECIMAL(18, 2) NOT NULL, -- Tổng tiền của đơn hàng
    ShippingAddressID INT, -- Liên kết với bảng ShippingInformation (được tạo sau)
    PaymentMethod VARCHAR(50), -- Phương thức thanh toán (COD, Bank Transfer, ...)
    PaymentStatus VARCHAR(50) DEFAULT 'Pending', -- Trạng thái thanh toán (Pending, Completed, Failed)
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng OrderItems: Chi tiết các sản phẩm trong mỗi đơn hàng
CREATE TABLE OrderItems (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    OrderID INT NOT NULL,
    ProductID INT NOT NULL,
    Quantity INT NOT NULL CHECK (Quantity > 0),
    PriceAtOrder DECIMAL(18, 2) NOT NULL, -- Giá sản phẩm tại thời điểm đặt hàng
    DiscountAtOrder DECIMAL(5, 2) DEFAULT 0.00, -- Giảm giá sản phẩm tại thời điểm đặt hàng
    Subtotal DECIMAL(18, 2) NOT NULL, -- (PriceAtOrder - DiscountAtOrder) * Quantity
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng Posts: Các bài viết/tin tức
CREATE TABLE Posts (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    AuthorID INT NOT NULL,
    ProductID INT, -- Có thể liên kết với sản phẩm (ví dụ: bài review sản phẩm)
    Title VARCHAR(255) NOT NULL,
    Slug VARCHAR(191) NOT NULL UNIQUE, -- Đã sửa độ dài Slug
    Content LONGTEXT NOT NULL,
    PostTypeID INT NOT NULL,
    TopicID INT,
    Status VARCHAR(50) NOT NULL DEFAULT 'Pending', -- Pending, Approved, Rejected
    Views INT DEFAULT 0,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng PostInteractions: Tương tác của người dùng với bài viết (Like/Share)
CREATE TABLE PostInteractions (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    PostID INT NOT NULL,
    UserID INT NOT NULL,
    InteractionType VARCHAR(50) NOT NULL, -- 'LIKE', 'SHARE'
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (PostID, UserID, InteractionType)
);

-- Bảng Comments: Bình luận của người dùng trên bài viết
CREATE TABLE Comments (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    PostID INT NOT NULL,
    UserID INT NOT NULL,
    ParentCommentID INT, -- Cho phép bình luận trả lời (nested comments)
    Content TEXT NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng Reviews: Đánh giá sản phẩm của người dùng
CREATE TABLE Reviews (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    ProductID INT NOT NULL,
    OrderID INT, -- Liên kết đánh giá với đơn hàng đã mua sản phẩm đó (có thể NULL nếu đánh giá chung)
    Rating INT NOT NULL CHECK (Rating >= 1 AND Rating <= 5), -- Điểm đánh giá từ 1 đến 5
    Content TEXT,
    Status VARCHAR(50) DEFAULT 'Pending', -- Trạng thái đánh giá (Pending, Approved, Rejected)
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng Carts: Giỏ hàng của người dùng
CREATE TABLE Carts (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    ProductID INT NOT NULL,
    Quantity INT NOT NULL CHECK (Quantity > 0),
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (UserID, ProductID)
);

-- Bảng ShippingInformation: Thông tin giao hàng của đơn hàng
CREATE TABLE ShippingInformation (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    OrderID INT NOT NULL UNIQUE, -- Mỗi đơn hàng có một thông tin giao hàng
    Address VARCHAR(255) NOT NULL,
    City VARCHAR(100),
    State VARCHAR(100),
    PostalCode VARCHAR(20),
    RecipientName VARCHAR(255) NOT NULL,
    RecipientPhone VARCHAR(20) NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng OrderTransactions: Bản ghi giao dịch thanh toán
-- Điều chỉnh cho phương thức thanh toán không phức tạp (chủ yếu là COD, chuyển khoản thủ công)
CREATE TABLE OrderTransactions (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    OrderID INT NOT NULL UNIQUE, -- Mỗi đơn hàng có một giao dịch chính
    PaymentMethod VARCHAR(50) NOT NULL, -- Ví dụ: 'COD', 'Bank Transfer', 'Manual'
    Amount DECIMAL(18, 2) NOT NULL,
    Currency VARCHAR(10) DEFAULT 'VND',
    Status VARCHAR(50) DEFAULT 'Pending', -- Ví dụ: 'Pending', 'Paid', 'Refunded'
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng ProductFavorites: Danh sách sản phẩm yêu thích của người dùng
CREATE TABLE ProductFavorites (
    UserID INT NOT NULL,
    ProductID INT NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (UserID, ProductID)
);

-- Bảng Notifications: Hệ thống thông báo cho người dùng
CREATE TABLE Notifications (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    Title VARCHAR(255) NOT NULL,
    Content TEXT NOT NULL,
    URL VARCHAR(255),
    IsRead BOOLEAN DEFAULT FALSE,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng Configurations: Cấu hình hệ thống (ví dụ: ngưỡng cảnh báo tồn kho, phí ship)
CREATE TABLE Configurations (
    SettingKey VARCHAR(100) PRIMARY KEY,
    SettingValue TEXT,
    Description VARCHAR(255),
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng ShipperAssignments: Gán đơn hàng cho đối tác vận chuyển
CREATE TABLE ShipperAssignments (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    OrderID INT NOT NULL UNIQUE,
    ShipperID INT NOT NULL,
    AssignedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    PickedUpAt DATETIME,
    DeliveredAt DATETIME,
    FailedAt DATETIME,
    Notes TEXT,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng UserActivities: Nhật ký hoạt động của người dùng (cho mục đích kiểm toán và bảo mật)
CREATE TABLE UserActivities (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    ActionType VARCHAR(50) NOT NULL,
    Details TEXT,
    IPAddress VARCHAR(50),
    UserAgent TEXT,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 4. THIẾT LẬP CÁC KHÓA NGOẠI (FOREIGN KEY)

ALTER TABLE Users
ADD CONSTRAINT FK_Users_Roles FOREIGN KEY (RoleID) REFERENCES Roles(ID) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE Categories
ADD CONSTRAINT FK_Categories_ParentCategory FOREIGN KEY (ParentID) REFERENCES Categories(ID) ON UPDATE CASCADE ON DELETE SET NULL;

ALTER TABLE Products
ADD CONSTRAINT FK_Products_Categories FOREIGN KEY (CategoryID) REFERENCES Categories(ID) ON UPDATE CASCADE ON DELETE RESTRICT,
ADD CONSTRAINT FK_Products_Brands FOREIGN KEY (BrandID) REFERENCES Brands(ID) ON UPDATE CASCADE ON DELETE RESTRICT,
ADD CONSTRAINT FK_Products_Salers FOREIGN KEY (SalerID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE ProductImages
ADD CONSTRAINT FK_ProductImages_Products FOREIGN KEY (ProductID) REFERENCES Products(ID) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE Orders
ADD CONSTRAINT FK_Orders_Users FOREIGN KEY (UserID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE RESTRICT,
ADD CONSTRAINT FK_Orders_Salers FOREIGN KEY (SalerID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE RESTRICT,
ADD CONSTRAINT FK_Orders_OrderStatuses FOREIGN KEY (OrderStatusID) REFERENCES OrderStatuses(ID) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE OrderItems
ADD CONSTRAINT FK_OrderItems_Orders FOREIGN KEY (OrderID) REFERENCES Orders(ID) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT FK_OrderItems_Products FOREIGN KEY (ProductID) REFERENCES Products(ID) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE Posts
ADD CONSTRAINT FK_Posts_Users FOREIGN KEY (AuthorID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE RESTRICT,
ADD CONSTRAINT FK_Posts_Products FOREIGN KEY (ProductID) REFERENCES Products(ID) ON UPDATE CASCADE ON DELETE SET NULL,
ADD CONSTRAINT FK_Posts_PostTypes FOREIGN KEY (PostTypeID) REFERENCES PostTypes(ID) ON UPDATE CASCADE ON DELETE RESTRICT,
ADD CONSTRAINT FK_Posts_Topics FOREIGN KEY (TopicID) REFERENCES Topics(ID) ON UPDATE CASCADE ON DELETE SET NULL;

ALTER TABLE PostInteractions
ADD CONSTRAINT FK_PostInteractions_Posts FOREIGN KEY (PostID) REFERENCES Posts(ID) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT FK_PostInteractions_Users FOREIGN KEY (UserID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE Comments
ADD CONSTRAINT FK_Comments_Posts FOREIGN KEY (PostID) REFERENCES Posts(ID) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT FK_Comments_Users FOREIGN KEY (UserID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT FK_Comments_ParentComment FOREIGN KEY (ParentCommentID) REFERENCES Comments(ID) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE Reviews
ADD CONSTRAINT FK_Reviews_Users FOREIGN KEY (UserID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE RESTRICT,
ADD CONSTRAINT FK_Reviews_Products FOREIGN KEY (ProductID) REFERENCES Products(ID) ON UPDATE CASCADE ON DELETE RESTRICT,
ADD CONSTRAINT FK_Reviews_Orders FOREIGN KEY (OrderID) REFERENCES Orders(ID) ON UPDATE CASCADE ON DELETE SET NULL;

ALTER TABLE Carts
ADD CONSTRAINT FK_Carts_Users FOREIGN KEY (UserID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT FK_Carts_Products FOREIGN KEY (ProductID) REFERENCES Products(ID) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ShippingInformation
ADD CONSTRAINT FK_ShippingInfo_Orders FOREIGN KEY (OrderID) REFERENCES Orders(ID) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE OrderTransactions
ADD CONSTRAINT FK_OrderTransactions_Orders FOREIGN KEY (OrderID) REFERENCES Orders(ID) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ProductFavorites
ADD CONSTRAINT FK_ProductFavorites_Users FOREIGN KEY (UserID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT FK_ProductFavorites_Products FOREIGN KEY (ProductID) REFERENCES Products(ID) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE Notifications
ADD CONSTRAINT FK_Notifications_Users FOREIGN KEY (UserID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ShipperAssignments
ADD CONSTRAINT FK_ShipperAssignments_Orders FOREIGN KEY (OrderID) REFERENCES Orders(ID) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT FK_ShipperAssignments_Shippers FOREIGN KEY (ShipperID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE UserActivities
ADD CONSTRAINT FK_UserActivities_Users FOREIGN KEY (UserID) REFERENCES Users(ID) ON UPDATE CASCADE ON DELETE SET NULL;