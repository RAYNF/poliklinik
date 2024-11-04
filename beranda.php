<!-- start home -->
<div class="container-xxl">
    <!-- start home section -->
    <section class="hero mt-5" id="hero">
        <div class="hero-wrapper d-flex flex-md-row flex-column gap-md-0 gap-5 ">
            <img src="assets/doctor.png" alt="home" />
            <div class="hero-content text-md-end px-2 text-center">
                <h1 class="hero-title text-uppercase fw-bold fs-2">
                    Kesehatan Adalah Anugrah
                </h1>
                <p class="hero-description fs-md-5 fs-4 fw-semibold ">
                    Konsultasikan masalah kesehatan dengan yang sudah berpengalaman dan sudah hadir membantu masyarakat sejak 1999
                </p>
                <button
                    class="hero-button btn text-white fs-5 border-3 border-black border-opacity-50 gap-3 fw-semibold rounded-pill px-md-4 py-md-2" onclick="scrollToAbout()">
                    Explore <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </section>
    <!-- end home section -->

    <!-- start about section -->
    <section class="about mt-5" id="about">
        <div
            class="about-wrapper d-flex align-items-center flex-md-row flex-column-reverse">
            <div class="about-content">
                <h1 class="about-title text-uppercase fw-bold fs-2 mb-4">About</h1>
                <p class="about-desc fs-6 px-5 px-md-0 fw-semibold">
                    Kami percaya bahwa kesehatan adalah aset terpenting yang dimiliki setiap individu.
                    Sejak tahun 1999, kami telah berdedikasi memberikan pelayanan kesehatan terbaik untuk
                    masyarakat. Dengan tenaga medis berpengalaman dan fasilitas modern, kami berkomitmen
                    untuk mendampingi Anda dalam setiap langkah menuju hidup yang lebih sehat. Klinik kami
                    menyediakan konsultasi, pemeriksaan, serta solusi kesehatan yang dirancang untuk memenuhi
                    kebutuhan Anda dengan penuh perhatian dan profesionalisme. Bersama kami, Anda berada di
                    tangan yang tepat.
                </p>
            </div>
            <img src="assets/dashboard.jpg" alt="about" class="w-md-75 w-50" />
        </div>
    </section>
    <!-- end about section -->


    <!-- start contact section -->
    <section id="contact" class="mt-5">
        <div class="contact-wrapper d-flex gap-5 flex-md-row flex-column">
            <img src="assets/img_contact.png" alt="contcact">

            <div class="contact-content text-md-end text-center">
                <h1 class="contact-title fs-1 fw-bold text-uppercase">Contact us</h1>
                <p class="contact-desc fs-5 fw-semibold px-2 px-md-0">Ada pertanyaan atau ingin berbagi pendapat?<br><span>Silahkan hubungi kami!</span></br></p>
                <button class="contact-button border-2 border-black rounded-pill btn text-white fw-bold">Contact us <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </section>
    <!-- end contact section -->


    </section>
    <!-- end footer -->
</div>

<script>
    function scrollToAbout() {
        const aboutSection = document.getElementById("about");
        aboutSection.scrollIntoView({
            behavior: "smooth"
        });
    }
</script>