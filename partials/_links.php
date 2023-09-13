<div class="box-item" id="links">
    <?php
    if ($userUrls->num_rows > 0) {
        foreach ($userUrls as $key => $url) {
            ?>
            <div class="link-item">
                <div class="content">
                    <div class="head">
                        <i class="fa-solid  fa-link"></i>
                        <span class="short-link">
                            <?php echo $url['short_url'] ?>
                        </span>
                    </div>
                    <div class="link-info">
                        <div class="url">
                            <div class="full-url"> <i class="fa-solid fa-globe"></i>&nbsp;&nbsp;<span>
                                    <?php echo $url['long_url'] ?>
                                </span>
                            </div>
                            <div class="click-count"> &nbsp; | &nbsp;Toplam Tıklama :
                                <?php echo $url['click'] ?>
                            </div>
                        </div>
                        <input type="text" name="short-url" value="nakres.link/<?php echo $url['short_url'] ?>">
                        <div class="create-date">Kısaltma Tarihi : <span class="date">
                                <?php echo $url['create_date'] ?>
                            </span></div>
                    </div>
                </div>
                <div class="link-action">
                    <button data-tag="<?php echo $url['id'] ?>" class="edit-url">Düzenle</button>
                    <button data-tag="<?php echo $url['id'] ?>" class="delete-url">Sil</button>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>