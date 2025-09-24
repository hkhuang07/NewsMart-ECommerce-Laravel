-- Tạo database mới
CREATE DATABASE NewsMartDB;
GO

-- Sử dụng database
USE NewsMartDB;
GO

-- Tạo các bảng phụ trợ trước
CREATE TABLE Roles (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    Name NVARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE OrderStatuses (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    Name NVARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE Topics (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    Name NVARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE PostTypes (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    Name NVARCHAR(255) NOT NULL UNIQUE
);

---

-- 1. Tạo và nâng cấp các bảng hiện có

-- Bảng Users
CREATE TABLE Users (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    FullName NVARCHAR(255) NOT NULL,
    Username NVARCHAR(255) NOT NULL UNIQUE,
    Email NVARCHAR(255) NOT NULL UNIQUE, -- Thêm trường Email
    Password NVARCHAR(255) NOT NULL,
    RoleID INT,
    IsActive BIT DEFAULT 1,
    CreatedAt DATETIME DEFAULT GETDATE(),
    UpdatedAt DATETIME DEFAULT GETDATE()
);

-- Bảng Categories
CREATE TABLE Categories (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    Name NVARCHAR(255) NOT NULL UNIQUE,
    CreatedAt DATETIME DEFAULT GETDATE(),
    UpdatedAt DATETIME DEFAULT GETDATE()
);

-- Bảng Brands
CREATE TABLE Brands (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    Name NVARCHAR(255) NOT NULL UNIQUE,
    Address NVARCHAR(255),
    Email VARCHAR(255),
    Contact VARCHAR(50),
    CreatedAt DATETIME DEFAULT GETDATE(),
    UpdatedAt DATETIME DEFAULT GETDATE()
);

-- Bảng Products
CREATE TABLE Products (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    CategoryID INT NOT NULL,
    BrandID INT NOT NULL,
    Name NVARCHAR(255) NOT NULL,
    Description NVARCHAR(MAX),
    Price DECIMAL(18, 2) NOT NULL,
    StockQuantity INT NOT NULL DEFAULT 0,
    Discount DECIMAL(5, 2) DEFAULT 0.00,
    AverageRate DECIMAL(2, 1) DEFAULT 0.0,
    CreatedAt DATETIME DEFAULT GETDATE(),
    UpdatedAt DATETIME DEFAULT GETDATE()
);

-- Bảng ProductImages
CREATE TABLE ProductImages (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    ProductID INT NOT NULL,
    URL NVARCHAR(255) NOT NULL,
    IsMainImage BIT DEFAULT 0,
    CreatedAt DATETIME DEFAULT GETDATE(),
    UpdatedAt DATETIME DEFAULT GETDATE()
);

-- Bảng Orders
CREATE TABLE Orders (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    UserID INT NOT NULL,
	SalerID INT NOT NULL,
    OrderDate DATE NOT NULL,
    OrderStatusID INT NOT NULL,
    CreatedAt DATETIME DEFAULT GETDATE(),
    UpdatedAt DATETIME DEFAULT GETDATE()
);

-- Bảng OrderItems
CREATE TABLE OrderItems (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    OrderID INT NOT NULL,
    ProductID INT NOT NULL,
    Quantity INT NOT NULL,
    PriceAtOrder DECIMAL(18, 2) NOT NULL,
    CreatedAt DATETIME DEFAULT GETDATE(),
    UpdatedAt DATETIME DEFAULT GETDATE()
);

-- Bảng Posts
CREATE TABLE Posts (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    AuthorID INT NOT NULL,
    ProductID INT,
    Title NVARCHAR(255) NOT NULL,
    Content NVARCHAR(MAX) NOT NULL,
    PostTypeID INT NOT NULL,
    TopicID INT,
    Views INT DEFAULT 0, -- Thêm trường Views
    CreatedAt DATETIME DEFAULT GETDATE(),
    UpdatedAt DATETIME DEFAULT GETDATE()
);

-- Bảng PostInteractions
CREATE TABLE PostInteractions (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    PostID INT NOT NULL,
    UserID INT NOT NULL,
    InteractionType NVARCHAR(50) NOT NULL,
    CreatedAt DATETIME DEFAULT GETDATE()
);

-- Bảng Comments
CREATE TABLE Comments (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    PostID INT NOT NULL,
    UserID INT NOT NULL,
    ParentCommentID INT,
    Content NVARCHAR(MAX) NOT NULL,
    CreatedAt DATETIME DEFAULT GETDATE(),
    UpdatedAt DATETIME DEFAULT GETDATE()
);

---

-- 2. Tạo các bảng mới bổ sung

-- Bảng Reviews (Đánh giá)
CREATE TABLE Reviews (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    UserID INT NOT NULL,
    ProductID INT NOT NULL,
    Rating INT NOT NULL,
    Content NVARCHAR(MAX),
    CreatedAt DATETIME DEFAULT GETDATE(),
    UpdatedAt DATETIME DEFAULT GETDATE()
);

-- Bảng Carts (Giỏ hàng)
CREATE TABLE Carts (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    UserID INT NOT NULL,
    ProductID INT NOT NULL,
    Quantity INT NOT NULL,
    CreatedAt DATETIME DEFAULT GETDATE()
);

-- Bảng ShippingInformation (Thông tin vận chuyển)
CREATE TABLE ShippingInformation (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    OrderID INT NOT NULL,
    Address NVARCHAR(255) NOT NULL,
    City NVARCHAR(100),
    State NVARCHAR(100),
    PostalCode NVARCHAR(20),
    RecipientName NVARCHAR(255) NOT NULL,
    RecipientPhone VARCHAR(20) NOT NULL
);

-- Bảng OrderTransactions (Giao dịch đơn hàng)
CREATE TABLE OrderTransactions (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    OrderID INT NOT NULL,
    TransactionID NVARCHAR(255) UNIQUE,
    PaymentMethod NVARCHAR(50),
    Amount DECIMAL(18, 2),
    Status NVARCHAR(50),
    CreatedAt DATETIME DEFAULT GETDATE()
);

---

-- 3. Thiết lập các khóa ngoại (FOREIGN KEY) cho tất cả các bảng

ALTER TABLE Users
ADD CONSTRAINT FK_Users_Roles FOREIGN KEY (RoleID) REFERENCES Roles(ID);

ALTER TABLE Products
ADD CONSTRAINT FK_Products_Categories FOREIGN KEY (CategoryID) REFERENCES Categories(ID),
    CONSTRAINT FK_Products_Brands FOREIGN KEY (BrandID) REFERENCES Brands(ID);

ALTER TABLE ProductImages
ADD CONSTRAINT FK_ProductImages_Products FOREIGN KEY (ProductID) REFERENCES Products(ID);

ALTER TABLE Orders
ADD CONSTRAINT FK_Orders_Users FOREIGN KEY (UserID) REFERENCES Users(ID),
    CONSTRAINT FK_Orders_OrderStatuses FOREIGN KEY (OrderStatusID) REFERENCES OrderStatuses(ID);

ALTER TABLE OrderItems
ADD CONSTRAINT FK_OrderItems_Orders FOREIGN KEY (OrderID) REFERENCES Orders(ID),
    CONSTRAINT FK_OrderItems_Products FOREIGN KEY (ProductID) REFERENCES Products(ID);

ALTER TABLE Posts
ADD CONSTRAINT FK_Posts_Users FOREIGN KEY (AuthorID) REFERENCES Users(ID),
    CONSTRAINT FK_Posts_Products FOREIGN KEY (ProductID) REFERENCES Products(ID),
    CONSTRAINT FK_Posts_PostTypes FOREIGN KEY (PostTypeID) REFERENCES PostTypes(ID),
    CONSTRAINT FK_Posts_Topics FOREIGN KEY (TopicID) REFERENCES Topics(ID);

ALTER TABLE PostInteractions
ADD CONSTRAINT FK_PostInteractions_Posts FOREIGN KEY (PostID) REFERENCES Posts(ID),
    CONSTRAINT FK_PostInteractions_Users FOREIGN KEY (UserID) REFERENCES Users(ID);

ALTER TABLE Comments
ADD CONSTRAINT FK_Comments_Posts FOREIGN KEY (PostID) REFERENCES Posts(ID),
    CONSTRAINT FK_Comments_Users FOREIGN KEY (UserID) REFERENCES Users(ID),
    CONSTRAINT FK_Comments_ParentComment FOREIGN KEY (ParentCommentID) REFERENCES Comments(ID);

-- Khóa ngoại cho các bảng mới
ALTER TABLE Reviews
ADD CONSTRAINT FK_Reviews_Users FOREIGN KEY (UserID) REFERENCES Users(ID),
    CONSTRAINT FK_Reviews_Products FOREIGN KEY (ProductID) REFERENCES Products(ID);

ALTER TABLE Carts
ADD CONSTRAINT FK_Carts_Users FOREIGN KEY (UserID) REFERENCES Users(ID),
    CONSTRAINT FK_Carts_Products FOREIGN KEY (ProductID) REFERENCES Products(ID);

ALTER TABLE ShippingInformation
ADD CONSTRAINT FK_ShippingInfo_Orders FOREIGN KEY (OrderID) REFERENCES Orders(ID);

ALTER TABLE OrderTransactions
ADD CONSTRAINT FK_OrderTransactions_Orders FOREIGN KEY (OrderID) REFERENCES Orders(ID);