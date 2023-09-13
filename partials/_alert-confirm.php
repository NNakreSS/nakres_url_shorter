<div class="overlay" id="overlay"></div>
<div class="custom-confirm" id="custom-confirm">
    <p>Yapmak istediniz işlemi onaylıyor musunuz ?</p>
    <button id="confirm-yes" class="button green">Evet</button>
    <button id="confirm-no" class="button red">Hayır</button>
</div>
<div class="alert-box"></div>
<div id="edit-user-box">
    <label><i class="fa-solid fa-user-plus"></i>Üye Düzenle</label>
    <div class="content">
        <input type="text" name="username" id="edit_user_name">
        <input type="text" name="password" id="edit_user_password" placeholder="Şifre : değişmeyecekse boş bırak">
        <div class="check-box">
            <span>Admin Yetkisi :</span>
            <input type="checkbox" name="isAdmin" id="edit_user_isAdmin">
        </div>
        <button id="save_edit_user" class="button green">Kaydet</button>
        <button id="cancel_edit_user" class="button red">İptal</button>
    </div>
</div>