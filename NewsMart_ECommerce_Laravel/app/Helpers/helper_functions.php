<?php

use App\Helpers\PermissionHelper;

// Create global helper functions that wrap PermissionHelper methods
if (!function_exists('getUserRole')) {
    function getUserRole() {
        return PermissionHelper::getUserRole();
    }
}

if (!function_exists('getUserRoleId')) {
    function getUserRoleId() {
        return PermissionHelper::getUserRoleId();
    }
}

if (!function_exists('hasRole')) {
    function hasRole($roleName) {
        return PermissionHelper::hasRole($roleName);
    }
}

if (!function_exists('hasAnyRole')) {
    function hasAnyRole($roles) {
        return PermissionHelper::hasAnyRole($roles);
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin() {
        return PermissionHelper::isAdmin();
    }
}

if (!function_exists('isManager')) {
    function isManager() {
        return PermissionHelper::isManager();
    }
}

if (!function_exists('isSaler')) {
    function isSaler() {
        return PermissionHelper::isSaler();
    }
}

if (!function_exists('isShipper')) {
    function isShipper() {
        return PermissionHelper::isShipper();
    }
}

if (!function_exists('isStandardUser')) {
    function isStandardUser() {
        return PermissionHelper::isStandardUser();
    }
}

if (!function_exists('hasAdminAccess')) {
    function hasAdminAccess() {
        return PermissionHelper::hasAdminAccess();
    }
}

if (!function_exists('hasManagerAccess')) {
    function hasManagerAccess() {
        return PermissionHelper::hasManagerAccess();
    }
}

if (!function_exists('hasSalesAccess')) {
    function hasSalesAccess() {
        return PermissionHelper::hasSalesAccess();
    }
}

if (!function_exists('hasShippingAccess')) {
    function hasShippingAccess() {
        return PermissionHelper::hasShippingAccess();
    }
}

if (!function_exists('canManageSystem')) {
    function canManageSystem() {
        return PermissionHelper::canManageSystem();
    }
}

if (!function_exists('canManageRoles')) {
    function canManageRoles() {
        return PermissionHelper::canManageRoles();
    }
}

if (!function_exists('canManageUsers')) {
    function canManageUsers() {
        return PermissionHelper::canManageUsers();
    }
}

if (!function_exists('canManageProducts')) {
    function canManageProducts() {
        return PermissionHelper::canManageProducts();
    }
}

if (!function_exists('canManageCategories')) {
    function canManageCategories() {
        return PermissionHelper::canManageCategories();
    }
}

if (!function_exists('canManageSuppliers')) {
    function canManageSuppliers() {
        return PermissionHelper::canManageSuppliers();
    }
}

if (!function_exists('canManageOrders')) {
    function canManageOrders() {
        return PermissionHelper::canManageOrders();
    }
}

if (!function_exists('canUpdateOrderStatus')) {
    function canUpdateOrderStatus() {
        return PermissionHelper::canUpdateOrderStatus();
    }
}

if (!function_exists('canManagePosts')) {
    function canManagePosts() {
        return PermissionHelper::canManagePosts();
    }
}

if (!function_exists('canViewReports')) {
    function canViewReports() {
        return PermissionHelper::canViewReports();
    }
}

if (!function_exists('canManageComments')) {
    function canManageComments() {
        return PermissionHelper::canManageComments();
    }
}

if (!function_exists('canManageReviews')) {
    function canManageReviews() {
        return PermissionHelper::canManageReviews();
    }
}

if (!function_exists('canAccessAdminPanel')) {
    function canAccessAdminPanel() {
        return PermissionHelper::canAccessAdminPanel();
    }
}

if (!function_exists('canManageNotifications')) {
    function canManageNotifications() {
        return PermissionHelper::canManageNotifications();
    }
}

if (!function_exists('canViewUserActivities')) {
    function canViewUserActivities() {
        return PermissionHelper::canViewUserActivities();
    }
}

if (!function_exists('getCurrentUserName')) {
    function getCurrentUserName() {
        return PermissionHelper::getCurrentUserName();
    }
}

if (!function_exists('canManageConfigurations')) {
    function canManageConfigurations() {
        return PermissionHelper::canManageConfigurations();
    }
}

if (!function_exists('isUserActive')) {
    function isUserActive() {
        return PermissionHelper::isUserActive();
    }
}
