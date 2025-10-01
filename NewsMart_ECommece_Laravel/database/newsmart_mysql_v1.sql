
-- 1. TẠO DATABASE
CREATE DATABASE IF NOT EXISTS NewsMartDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Sử dụng database
USE NewsMartDB;

-- 2. TẠO CÁC BẢNG PHỤ TRỢ (Lookup Tables)

-- Cột Name (VARCHAR(255) NOT NULL UNIQUE) cần được sửa
CREATE TABLE Roles (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    UNIQUE KEY (Name(191)) -- Giới hạn độ dài index
);

CREATE TABLE OrderStatuses (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    UNIQUE KEY (Name(191))
);

CREATE TABLE Topics (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    UNIQUE KEY (Name(191))
);

CREATE TABLE PostTypes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    UNIQUE KEY (Name(191))
);

-- 3. TẠO VÀ NÂNG CẤP CÁC BẢNG CHÍNH

-- Bảng Users
-- Username và Email là các cột UNIQUE, cần sửa
CREATE TABLE Users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(255) NOT NULL,
    Username VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL, 
    Password VARCHAR(255) NOT NULL,
    RoleID INT,
    IsActive BOOLEAN DEFAULT TRUE,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY (Username(191)), -- Giới hạn index cho Username
    UNIQUE KEY (Email(191))     -- Giới hạn index cho Email
);

-- Bảng Categories
CREATE TABLE Categories (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY (Name(191)) -- Giới hạn index cho Name
);

-- Bảng Brands
CREATE TABLE Brands (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Address VARCHAR(255),
    Email VARCHAR(255),
    Contact VARCHAR(50),
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY (Name(191)) -- Giới hạn index cho Name
);

-- Bảng Products (Không có lỗi 1071 vì không có cột VARCHAR(255) UNIQUE)
CREATE TABLE Products (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    CategoryID INT NOT NULL,
    BrandID INT NOT NULL,
    Name VARCHAR(255) NOT NULL,
    Description TEXT,
    Price DECIMAL(18, 2) NOT NULL,
    StockQuantity INT NOT NULL DEFAULT 0,
    Discount DECIMAL(5, 2) DEFAULT 0.00,
    AverageRate DECIMAL(2, 1) DEFAULT 0.0,
    Favorites INT DEFAULT 0,
    Purchases INT DEFAULT 0,
    Views INT DEFAULT 0, 
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng ProductImages (Không có lỗi 1071)
CREATE TABLE ProductImages (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ProductID INT NOT NULL,
    URL VARCHAR(255) NOT NULL,
    IsMainImage BOOLEAN DEFAULT FALSE,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng Orders (Không có lỗi 1071)
CREATE TABLE Orders (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
	SalerID INT NOT NULL,
    OrderDate DATE NOT NULL,
    OrderStatusID INT NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng OrderItems (Không có lỗi 1071)
CREATE TABLE OrderItems (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    OrderID INT NOT NULL,
    ProductID INT NOT NULL,
    Quantity INT NOT NULL,
    PriceAtOrder DECIMAL(18, 2) NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng Posts (Không có lỗi 1071)
CREATE TABLE Posts (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    AuthorID INT NOT NULL,
    ProductID INT,
    Title VARCHAR(255) NOT NULL,
    Content LONGTEXT NOT NULL,
    PostTypeID INT NOT NULL,
    TopicID INT,
	Status VARCHAR(50) NOT NULL DEFAULT 'Pending',
    Views INT DEFAULT 0, 
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng PostInteractions (Không có lỗi 1071)
CREATE TABLE PostInteractions (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    PostID INT NOT NULL,
    UserID INT NOT NULL,
    InteractionType VARCHAR(50) NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng Comments (Không có lỗi 1071)
CREATE TABLE Comments (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    PostID INT NOT NULL,
    UserID INT NOT NULL,
    ParentCommentID INT,
    Content TEXT NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng Reviews (Đánh giá)
CREATE TABLE Reviews (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    ProductID INT NOT NULL,
    Rating INT NOT NULL,
    Content TEXT,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng Carts (Giỏ hàng)
CREATE TABLE Carts (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    ProductID INT NOT NULL,
    Quantity INT NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng ShippingInformation (Không có lỗi 1071)
CREATE TABLE ShippingInformation (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    OrderID INT NOT NULL,
    Address VARCHAR(255) NOT NULL,
    City VARCHAR(100),
    State VARCHAR(100),
    PostalCode VARCHAR(20),
    RecipientName VARCHAR(255) NOT NULL,
    RecipientPhone VARCHAR(20) NOT NULL
);

-- Bảng OrderTransactions
-- TransactionID là cột UNIQUE VARCHAR(255), cần sửa
CREATE TABLE OrderTransactions (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    OrderID INT NOT NULL,
    TransactionID VARCHAR(255),
    PaymentMethod VARCHAR(50),
    Amount DECIMAL(18, 2),
    Status VARCHAR(50),
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (TransactionID(191)) -- Giới hạn index cho TransactionID
);


-- 4. THIẾT LẬP CÁC KHÓA NGOẠI (FOREIGN KEY)
-- Khóa ngoại thường không gây lỗi 1071 trừ khi nó tham chiếu đến một cột bị giới hạn độ dài, nhưng ta đã sửa ở bước 3, nên phần này giữ nguyên.

ALTER TABLE Users
ADD CONSTRAINT FK_Users_Roles FOREIGN KEY (RoleID) REFERENCES Roles(ID);

ALTER TABLE Products
ADD CONSTRAINT FK_Products_Categories FOREIGN KEY (CategoryID) REFERENCES Categories(ID),
    ADD CONSTRAINT FK_Products_Brands FOREIGN KEY (BrandID) REFERENCES Brands(ID);

ALTER TABLE ProductImages
ADD CONSTRAINT FK_ProductImages_Products FOREIGN KEY (ProductID) REFERENCES Products(ID);

ALTER TABLE Orders
ADD CONSTRAINT FK_Orders_Users FOREIGN KEY (UserID) REFERENCES Users(ID),
    ADD CONSTRAINT FK_Orders_OrderStatuses FOREIGN KEY (OrderStatusID) REFERENCES OrderStatuses(ID);

ALTER TABLE Orders
ADD CONSTRAINT FK_Orders_Salers FOREIGN KEY (SalerID) REFERENCES Users(ID); 

ALTER TABLE OrderItems
ADD CONSTRAINT FK_OrderItems_Orders FOREIGN KEY (OrderID) REFERENCES Orders(ID),
    ADD CONSTRAINT FK_OrderItems_Products FOREIGN KEY (ProductID) REFERENCES Products(ID);

ALTER TABLE Posts
ADD CONSTRAINT FK_Posts_Users FOREIGN KEY (AuthorID) REFERENCES Users(ID),
    ADD CONSTRAINT FK_Posts_Products FOREIGN KEY (ProductID) REFERENCES Products(ID),
    ADD CONSTRAINT FK_Posts_PostTypes FOREIGN KEY (PostTypeID) REFERENCES PostTypes(ID),
    ADD CONSTRAINT FK_Posts_Topics FOREIGN KEY (TopicID) REFERENCES Topics(ID);

ALTER TABLE PostInteractions
ADD CONSTRAINT FK_PostInteractions_Posts FOREIGN KEY (PostID) REFERENCES Posts(ID),
    ADD CONSTRAINT FK_PostInteractions_Users FOREIGN KEY (UserID) REFERENCES Users(ID);

ALTER TABLE Comments
ADD CONSTRAINT FK_Comments_Posts FOREIGN KEY (PostID) REFERENCES Posts(ID),
    ADD CONSTRAINT FK_Comments_Users FOREIGN KEY (UserID) REFERENCES Users(ID),
    ADD CONSTRAINT FK_Comments_ParentComment FOREIGN KEY (ParentCommentID) REFERENCES Comments(ID);

ALTER TABLE Reviews
ADD CONSTRAINT FK_Reviews_Users FOREIGN KEY (UserID) REFERENCES Users(ID),
    ADD CONSTRAINT FK_Reviews_Products FOREIGN KEY (ProductID) REFERENCES Products(ID);

ALTER TABLE Carts
ADD CONSTRAINT FK_Carts_Users FOREIGN KEY (UserID) REFERENCES Users(ID),
    ADD CONSTRAINT FK_Carts_Products FOREIGN KEY (ProductID) REFERENCES Products(ID);

ALTER TABLE ShippingInformation
ADD CONSTRAINT FK_ShippingInfo_Orders FOREIGN KEY (OrderID) REFERENCES Orders(ID);

ALTER TABLE OrderTransactions
ADD CONSTRAINT FK_OrderTransactions_Orders FOREIGN KEY (OrderID) REFERENCES Orders(ID);


--UPDATE MỞ RỘNG
-- 1. Bảng ProductFavorites (Danh sách Yêu thích của Người dùng)
CREATE TABLE ProductFavorites (
    UserID INT NOT NULL,
    ProductID INT NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (UserID, ProductID), -- Khóa chính kép
    FOREIGN KEY (UserID) REFERENCES Users(ID),
    FOREIGN KEY (ProductID) REFERENCES Products(ID)
);

-- 2. Bảng Notifications (Hệ thống Thông báo)
CREATE TABLE Notifications (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    Title VARCHAR(255) NOT NULL,
    Content TEXT NOT NULL,
    URL VARCHAR(255), -- Link đến nội dung liên quan
    IsRead BOOLEAN DEFAULT FALSE,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(ID)
);

-- 3. Bảng Configurations (Cấu hình hệ thống)
CREATE TABLE Configurations (
    SettingKey VARCHAR(100) PRIMARY KEY, -- Ví dụ: 'SITE_NAME', 'SHIPPING_FEE'
    SettingValue TEXT,
    Description VARCHAR(255)
);

-- 4. Bảng DriverAssignments (Gán Đơn hàng cho Đối tác Vận chuyển)
CREATE TABLE ShipperAssignments (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    OrderID INT NOT NULL UNIQUE, -- Mỗi đơn hàng chỉ gán cho một tài xế
    DriverID INT NOT NULL,
    AssignedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (OrderID) REFERENCES Orders(ID),
    FOREIGN KEY (DriverID) REFERENCES Users(ID) -- DriverID là User có RoleID tương ứng
);

-- 5. Bảng UserActivities (Nhật ký Hoạt động)
CREATE TABLE UserActivities (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT, -- NULL nếu là khách không đăng nhập
    ActionType VARCHAR(50) NOT NULL, -- Ví dụ: 'LOGIN', 'CREATE_PRODUCT', 'BLOCK_USER'
    Details TEXT,
    IPAddress VARCHAR(50),
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(ID)
);