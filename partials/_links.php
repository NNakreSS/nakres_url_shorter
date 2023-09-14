<div class="box-item" id="links">
    <?php
    if ($userUrls->num_rows > 0) {
        foreach ($userUrls as $key => $url) {
            ?>
            <div class="link-item">
                <div class="content">
                    <div class="head">
                        <div onclick="executeCopy('<?php echo $config['domain'] . $url['short_url'] ?>')">
                            <div class="tooltip-hover-div">
                                <i class="fa-solid  fa-link"></i>
                                <span class="short-link">
                                    <?php echo $url['short_url'] ?>
                                </span>
                                <span class="tooltip-text">Kopyalamak içi tıkla</span>
                            </div>
                            <div class="click-count"> &nbsp; | &nbsp;Toplam Tıklama :
                                <?php echo $url['click'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="link-info">
                        <input type='text' id="input_long_url" data-url='<?php echo $url['long_url'] ?>'
                            value='<?php echo $url['long_url'] ?>'>
                        <input type="text" id="input_short_url" data-tag="<?php echo $url['short_url'] ?>" name="short-url"
                            placeholder="<?php echo $config['domain'] . $url['short_url'] ?>">
                        <div class="create-date">Kısaltma Tarihi : <span class="date">
                                <?php echo $url['create_date'] ?>
                            </span></div>
                    </div>
                </div>
                <div class="link-action">
                    <button data-tag="<?php echo $url['short_url'] ?>" data-url="<?php echo $url['long_url'] ?>"
                        class="edit-url button green">Düzenle</button>
                    <button data-tag="<?php echo $url['short_url'] ?>" data-url="<?php echo $url['long_url'] ?>"
                        class="delete-url button red">Sil</button>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<div id="non-link-info"> Oluşturulmuş herhangi bir kısa link mevcut değil.. </div>';
    }
    ?>
</div>