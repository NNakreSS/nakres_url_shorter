<div class="box-item" id="total-infos">
    <div id="total-click" class="total">
        <div class="total-conent">
            <div class="content-info">
                <i class="total-icon fa-solid fa-chart-simple"></i>
                <div class="total-text">
                    <div id="click-count">
                        <?php echo $clickCount ?>
                    </div>
                    <span>Tıklamalar</span>
                </div>
            </div>
            <i class="total-bg fa-solid fa-chart-simple"></i>
        </div>
    </div>
    <div id="total-link" class="total">
        <div class="total-conent">
            <div class="content-info">
                <i class="total-icon fa-solid fa-link"></i>
                <div class="total-text">
                    <div id="link-count">
                        <?php echo $userUrls->num_rows ?>
                    </div>
                    <span>Toplam Link</span>
                </div>
            </div>
            <i class="total-bg fa-solid fa-link"></i>
        </div>
    </div>
</div>