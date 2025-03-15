<?php

class HC_HTML_slider_template
{
    public static $transition_speed = 1500;
    public static $interval_speed = 2000;
    public static $first_timeout_speed = 1000;


    public static function singleItem($i)
    {
        ?>
        <div class="min-h-[80px] border hc_slide min-w-1/3 max-w-1/3 w-1/3 p-2">
            <?= $i ?>
        </div>
        <?php
    }
}


//HC_UPDATE remove mt
?>

<div id="hc_slider_container" class="mt-[1000px] w-full overflow-hidden">
    <div class="w-full flex" id="hc_slider">
        <?php
        HC_HTML_slider_template::singleItem(1);
        HC_HTML_slider_template::singleItem(2);
        HC_HTML_slider_template::singleItem(3);
        HC_HTML_slider_template::singleItem(4);
        HC_HTML_slider_template::singleItem(5);
        HC_HTML_slider_template::singleItem(6);
        ?>
    </div>
</div>

<style>
    #hc_slider {
        transition:
            <?= "transform " . HC_HTML_slider_template::$transition_speed . "ms ease-in-out" ?>
        ;
    }
</style>

<script>
    window.addEventListener("load", () => {
        function delay(milliseconds) {
            return new Promise(resolve => {
                setTimeout(resolve, milliseconds);
            });
        }
        const slider = document.querySelector("#hc_slider");

        // Create an IntersectionObserver
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(async (entry) => {
                if (!entry.isIntersecting) return;

                //Duplicating the first three so it looks like a smooth transition
                const og_slides = []

                document.querySelectorAll(".hc_slide").forEach(e => og_slides.push(e.cloneNode(true)));

                //Slider Logic
                let index = 0;
                const slides = document.querySelectorAll(".hc_slide");
                let slideWidth = slides[0].offsetWidth; // Slide width + margin

                window.addEventListener("resize", () => {
                    console.log('w resized'); //HC_REMOVE
                    const slides = document.querySelectorAll(".hc_slide");
                    slideWidth = slides[0].offsetWidth;
                    index = 0;
                    slider.style.transform = `translateX(-${0}px)`;

                    slides.forEach((slide, slideIndex) => {
                        if (slideIndex > og_slides.length - 1) slider.removeChild(slide);
                    })
                })

                async function moveSlider() {
                    index++;
                    let slideToTransfer = (index % og_slides.length) - 1;
                    if (slideToTransfer < 0) slideToTransfer = og_slides.length - 1
                    console.log('slide', slideToTransfer); //HC_REMOVE


                    slider.style.transform = `translateX(-${index * slideWidth}px)`;


                    slider.appendChild(og_slides[slideToTransfer].cloneNode(true))
                }

                await delay(<?= HC_HTML_slider_template::$first_timeout_speed ?>);
                moveSlider();
                setInterval(moveSlider, <?= HC_HTML_slider_template::$interval_speed ?>);

                observer.disconnect();
            });
        }, { threshold: 1 }); // Triggers when 50% of the element is visible

        // Start observing the element
        observer.observe(slider);
    })
</script>