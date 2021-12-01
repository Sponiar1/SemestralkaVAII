<?php /** @var Array $data */ ?>
<?php $i = 0 ?>
<div class="container">
    <div class="slideshow-container">

        <?php for($i = 1; $i < 4; $i++) { ?>
            <div class="sliders">
                <div class="numbertext"><?= $i ?>/ 3</div>
                <img src="<?= \App\Config\Configuration::UPLOAD_DIR . $data['posts'][$i-1]->getImage() ?>">
            </div>
        <?php } ?>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <br>
    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(0)"></span>
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
    </div>

    <div class="row">
        <div class="d-flex justify-content-start flex-wrap">
            <?php foreach ($data['posts'] as $post) { ?>
                <div class="fotka" style="width: 18rem; margin: 5px">
                    <img src="<?= \App\Config\Configuration::UPLOAD_DIR . $post->getImage() ?>" class="card-img-top" id="myImg<?= ++$i?>" onclick="showmodal(<?= $i?>)" alt="...">
                </div>
            <?php } ?>
        </div>
    </div>
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
    </div>
</div>
