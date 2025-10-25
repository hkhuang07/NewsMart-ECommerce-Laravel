<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    /**
     * Get current user's role name
     */
    public static function getUserRole()
    {
        if (!Auth::check()) return 'User';
        
        try {
            if (Auth::user()->role && Auth::user()->role->name) {
                return Auth::user()->role->name;
            }
        } catch (\Exception $e) {
        }
        return 'User';
    }
    
    /**
     * Get current user's role ID
     */
    public static function getUserRoleId()
    {
        if (!Auth::check()) return null;
        return Auth::user()->roleid ?? null;
    }
    
    /**
     * Check if user has specific role
     */
    public static function hasRole($roleName)
    {
        if (!Auth::check()) return false;
        return strtolower(self::getUserRole()) === strtolower($roleName);
    }
    
    /**
     * Check if user has any of the specified roles
     */
    public static function hasAnyRole($roles)
    {
        if (!Auth::check()) return false;
        $userRole = strtolower(self::getUserRole());
        return in_array($userRole, array_map('strtolower', $roles));
    }
    
    // Các hàm kiểm tra role cụ thể
    public static function isAdmin()
    {
        return self::hasRole('Admin');
    }
    
    public static function isManager()
    {
        return self::hasRole('Manager');
    }
    
    public static function isSaler()
    {
        return self::hasRole('Saler');
    }
    
    public static function isShipper()
    {
        return self::hasRole('Shipper');
    }
    
    public static function isStandardUser()
    {
        return self::hasRole('User');
    }
    
    // Các hàm phân quyền theo cấp độ
    public static function hasAdminAccess()
    {
        return self::isAdmin();
    }
    
    public static function hasManagerAccess()
    {
        return self::hasAnyRole(['Admin', 'Manager']);
    }
    
    public static function hasSalesAccess()
    {
        return self::hasAnyRole(['Admin', 'Manager', 'Saler']);
    }
    
    public static function hasShippingAccess()
    {
        return self::hasAnyRole(['Admin', 'Manager', 'Shipper']);
    }
    
    // Các hàm phân quyền chức năng cụ thể
    public static function canManageSystem()
    {
        return self::isAdmin();
    }
    
    public static function canManageRoles()
    {
        return self::isAdmin();
    }
    
    public static function canManageUsers()
    {
        return self::hasAnyRole(['Admin', 'Manager']);
    }
    
    public static function canManageProducts()
    {
        return self::hasAnyRole(['Admin', 'Manager', 'Saler']);
    }
    
    public static function canManageCategories()
    {
        return self::hasAnyRole(['Admin', 'Manager']);
    }
    
    public static function canManageSuppliers()
    {
        return self::hasAnyRole(['Admin', 'Manager']);
    }
    
    public static function canManageOrders()
    {
        return self::hasAnyRole(['Admin', 'Manager', 'Saler', 'Shipper']);
    }
    
    public static function canUpdateOrderStatus()
    {
        return self::hasAnyRole(['Admin', 'Manager', 'Shipper']);
    }
    
    public static function canManagePosts()
    {
        return self::hasAnyRole(['Admin', 'Manager', 'Saler']);
    }
    
    public static function canViewReports()
    {
        return self::hasAnyRole(['Admin', 'Manager', 'Saler']);
    }
    
    public static function canManageComments()
    {
        return self::hasAnyRole(['Admin', 'Manager']);
    }
    
    public static function canManageReviews()
    {
        return self::hasAnyRole(['Admin', 'Manager']);
    }
    
    public static function canAccessAdminPanel()
    {
        return self::hasAnyRole(['Admin', 'Manager', 'Saler', 'Shipper']);
    }
    
    public static function canManageNotifications()
    {
        return self::hasAnyRole(['Admin', 'Manager']);
    }
    
    public static function canViewUserActivities()
    {
        return self::hasAnyRole(['Admin', 'Manager']);
    }
    
    // Hàm hỗ trợ lấy thông tin user hiện tại
    public static function getCurrentUserName()
    {
        if (!Auth::check()) return 'Guest';
        return Auth::user()->fullname ?? Auth::user()->name ?? 'Unknown';
    }
    
    public static function isUserActive()
    {
        if (!Auth::check()) return false;
        return Auth::user()->isactive ?? false;
    }

    public static function canManageConfigurations()
    {
        // Chỉ Admin và Manager được phép quản lý cấu hình hệ thống
        return self::hasAnyRole(['Admin', 'Manager']);
    }
}
