<?php 
function hasPermission($permission_name) {
    global $dbh;
    $role_id = $_SESSION['role_id'];
    $stmt = $dbh->prepare ('
        SELECT COUNT(*) FROM role_permissions
        INNER JOIN permissions ON role_permissions.permission_id = permissions.id
        WHERE role_permissions.role_id = :role_id AND permissions.permission_name = :permission_name
    ');

    $stmt->execute(['role_id' => $role_id, 'permission_name' => $permission_name]);
    return $stmt->fetchColumn() > 0;
}
//
?>