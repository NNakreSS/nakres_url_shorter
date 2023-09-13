<div class="box-item" id="all-links">
    <label><i class="fa-solid fa-link"></i> Genel Link Listesi </label>
    <div id="link-list">
        <?php
        if ($_SESSION['isAdmin'] == 1) {
            if ($allUrls->num_rows > 0) {
                foreach ($allUrls as $key => $url) {
                    ?>
                    <div class="all-link item">
                        <div class="all-link info">
                            <a href="<?php echo $url['long_url'] ?>" target="_blank" class="all-link link">
                                nakres.link/<?php echo $url['short_url'] ?>
                            </a>
                            <div class="all-link creator">
                                Oluşturan Üye : <span class="cretor-name">
                                    <?php echo $url['owner_name'] ?>
                                </span>
                            </div>
                        </div>
                        <button data-tag="<?php echo $url['short_url'] ?>" class="all-link delete delete-url">Sil</button>
                    </div>
                    <?php
                }
            } else {
                echo '<div id="non-link-info"> Oluşturulmuş herhangi bir kısa link mevcut değil.. </div>';
            }
        } ?>
    </div>
</div>