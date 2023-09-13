<?php
if ($_SESSION['isAdmin'] == 1) {
    ?>
    <div class="box-item" id="users">
        <div id="users_box">
            <label><i class="fa-solid fa-user-check"></i> Üyeler </label>
            <div id="user-list">
                <?php
                if ($usersData->num_rows > 0) {
                    foreach ($usersData as $key => $user) {
                        ?>
                        <div class="user-item">
                            <i class="user-icon fa-solid fa-user"></i>
                            <div class="name">
                                <?php echo $user['user_name'] ?>
                            </div>
                            <div class="action-buttons">
                                <button data-userName="<?php echo $user['user_name'] ?>" data-userId="<?php echo $user['id'] ?>"
                                    class="edit-user">Düzenle</button>
                                <button data-userId="<?php echo $user['id'] ?>" class="delete-user">Sil</button>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>