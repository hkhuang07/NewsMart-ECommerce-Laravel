<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\PermissionHelper;

class PermissionController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    /**
     * @return bool Cho phép quản lý người dùng (Admin)
     */
    protected function canManageUsers()
    {
        return PermissionHelper::canManageUsers();
    }
    
    /**
     * @return bool Cho phép quản lý vai trò (Admin)
     */
    protected function canManageRoles()
    {
        return PermissionHelper::canManageRoles();
    }
    
    /**
     * @return bool Cho phép quản lý hệ thống (Admin)
     */
    protected function canManageSystem()
    {
        return PermissionHelper::canManageSystem();
    }


    // --- Phương thức kiểm tra Quyền Sản phẩm & Danh mục ---
    /**
     * @return bool Cho phép quản lý sản phẩm (Admin, Manager, Saler)
     */
    protected function canManageProducts()
    {
        return PermissionHelper::canManageProducts();
    }
    
    /**
     * @return bool Cho phép quản lý danh mục (Admin, Manager)
     */
    protected function canManageCategories()
    {
        return PermissionHelper::canManageCategories();
    }
    
    /**
     * @return bool Cho phép quản lý nhà cung cấp (Admin, Manager)
     */
    protected function canManageSuppliers()
    {
        return PermissionHelper::canManageSuppliers();
    }

    // --- Phương thức kiểm tra Quyền Đơn hàng & Vận chuyển ---
    
    /**
     * @return bool Cho phép quản lý đơn hàng (Admin, Manager, Saler, Shipper)
     */
    protected function canManageOrders()
    {
        return PermissionHelper::canManageOrders();
    }
    
    /**
     * @return bool Cho phép cập nhật trạng thái đơn hàng (Admin, Manager, Shipper)
     */
    protected function canUpdateOrderStatus()
    {
        return PermissionHelper::canUpdateOrderStatus();
    }

    // --- Phương thức kiểm tra Quyền Nội dung & Khác ---
    
    /**
     * @return bool Cho phép quản lý bài viết (Admin, Manager, Saler)
     */
    protected function canManagePosts()
    {
        return PermissionHelper::canManagePosts();
    }

    /**
     * @return bool Cho phép xem báo cáo (Admin, Manager, Saler)
     */
    protected function canViewReports()
    {
        return PermissionHelper::canViewReports();
    }
    
    /**
     * @return bool Cho phép quản lý bình luận (Admin, Manager)
     */
    protected function canManageComments()
    {
        return PermissionHelper::canManageComments();
    }
    
    /**
     * @return bool Cho phép quản lý đánh giá (Admin, Manager)
     */
    protected function canManageReviews()
    {
        return PermissionHelper::canManageReviews();
    }
    
    /**
     * @return bool Cho phép quản lý thông báo (Admin, Manager)
     */
    protected function canManageNotifications()
    {
        return PermissionHelper::canManageNotifications();
    }
    
    /**
     * @return bool Cho phép xem hoạt động người dùng (Admin, Manager)
     */
    protected function canViewUserActivities()
    {
        return PermissionHelper::canViewUserActivities();
    }

    protected function canManageConfigurations()
    {
        return PermissionHelper::canManageConfigurations();
    }
    
    /**
     * @return bool Cho phép truy cập bảng điều khiển Admin (Tất cả trừ User)
     */
    protected function canAccessAdminPanel()
    {
        return PermissionHelper::canAccessAdminPanel();
    }

    
    protected function hasAdminAccess()
    {
        return PermissionHelper::hasAdminAccess();
    }
    
    protected function hasManagerAccess()
    {
        return PermissionHelper::hasManagerAccess();
    }
    
    protected function hasSalesAccess()
    {
        return PermissionHelper::hasSalesAccess();
    }
    
    protected function hasShippingAccess()
    {
        return PermissionHelper::hasShippingAccess();
    }
}