<?php

class HC_HTML_slider_template
{
    public $id;
    public $slider_id;
    public $slide_id;

    public function singleItem($i)
    {
        ?>
        <div class="min-h-[80px] border <?= $this->slide_id ?> min-w-1/3 max-w-1/3 w-1/3 p-2">
            <?= $i ?>
        </div>
        <?php
    }

    public function __construct(
        $id,
        $transition_speed = 1500,
        $interval_speed = 2000,
        $first_timeout_speed = 1000
    ) {
        $this->id = $id;
        $this->slider_id = "hc_" . $id . "_slider";
        $this->slide_id = "hc_" . $id . "_slide";

        ?>
        <!-- //HC_UPDATE remove mt -->
        <div id="hc_slider_container" class="w-full overflow-hidden">
            <div class="w-full flex" id="<?= $this->slider_id ?>">
                <?php
                $this->singleItem(1);
                $this->singleItem(2);
                $this->singleItem(3);
                $this->singleItem(4);
                $this->singleItem(5);
                $this->singleItem(6);
                ?>
            </div>
        </div>

        <style>
            <?= "#$this->slider_id" ?>
                {
                transition:
                    <?= "transform " . $transition_speed . "ms ease-in-out" ?>
                ;
            }
        </style>

        <script>
            window.addEventListener("load", () => {
                //HC_UPDATE change every function to const
                function delay(milliseconds) {
                    return new Promise(resolve => {
                        setTimeout(resolve, milliseconds);
                    });
                }

                function isInViewport(element) {
                    const rect = element.getBoundingClientRect();
                    const scrolledHeight = window.innerHeight;

                    console.log('scrolled', scrolledHeight, rect.top, rect.bottom); //HC_REMOVE

                    return (
                        rect.top <= scrolledHeight && // Bottom of the element is inside viewport
                        rect.bottom > 0
                    );
                }

                const slider = document.querySelector("<?= "#$this->slider_id" ?>");

                let scrolling = false;
                let resizeFunc;
                let interval;
                document.addEventListener("scroll", async () => {
                    let intersect = isInViewport(slider)
                    console.log('intersect', intersect); //HC_REMOVE

                    if (!intersect) {
                        scrolling = false;
                        if (resizeFunc) {
                            resizeFunc();
                            window.removeEventListener("resize", resizeFunc)
                        }
                        if (interval) clearTimeout(interval);
                        return;
                    }

                    if (scrolling) return;
                    scrolling = true;

                    //Duplicating the first three so it looks like a smooth transition
                    const og_slides = []

                    document.querySelectorAll(".<?= $this->slide_id ?>").forEach(e => og_slides.push(e.cloneNode(true)));

                    //Slider Logic
                    let index = 0;
                    const slides = document.querySelectorAll(".<?= $this->slide_id ?>");
                    let slideWidth = slides[0].offsetWidth; // Slide width + margin

                    resizeFunc = () => {
                        console.log('w resized'); //HC_REMOVE
                        const slides = document.querySelectorAll(".<?= $this->slide_id ?>");
                        slideWidth = slides[0].offsetWidth;
                        index = 0;
                        slider.style.transform = `translateX(-${0}px)`;

                        slides.forEach((slide, slideIndex) => {
                            if (slideIndex > og_slides.length - 1) slider.removeChild(slide);
                        })
                    };
                    window.addEventListener("resize", resizeFunc)

                    async function moveSlider() {
                        index++;
                        let slideToTransfer = (index % og_slides.length) - 1;
                        if (slideToTransfer < 0) slideToTransfer = og_slides.length - 1
                        console.log('slide', slideToTransfer); //HC_REMOVE


                        slider.style.transform = `translateX(-${index * slideWidth}px)`;


                        slider.appendChild(og_slides[slideToTransfer].cloneNode(true))
                    }

                    await delay(<?= $first_timeout_speed ?>);
                    moveSlider();
                    interval = setInterval(moveSlider, <?= $interval_speed ?>);
                })
            })
        </script>
        <?php
    }
}

?>