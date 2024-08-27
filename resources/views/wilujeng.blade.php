<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SABA OUTDOOR MAJALAYA</title>
    <link rel="stylesheet" href="{{ asset('css/wilujeng/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <img src="{{ asset('gambar/logo.jpeg') }}" alt="SABA Outdoor Equipment Rent">
        <h1>SABA OUTDOOR EQUIPMENT RENT</h1>
    </header>
    <nav>
        <div class="menu">
            <h2>Menyediakan alat berkualitas demi kenyamanan anda dengan harga yang terjangkau</h2>
        </div>
        @if(!Auth::user())
        <form action="{{ route('login') }}">
                <button type="submit" class="button button-login">MASUK</button>
        </form>
        <form action="{{ route('register') }}">
                <button type="submit" class="button button-register">MENDAFTAR</button>
        </form>
        @else
        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
        @endif
    </nav>
    <main>
        <h2>Selamat Datang di SABA Outdoor Equipment Rent</h2>
        <h3>Kami menyediakan berbagai peralatan outdoor untuk kebutuhan petualangan Anda.</h3>
        <p>Untuk bisa mengakses penyewaan anda harus LOGIN pada tomvol masuk dan register pada tombol mendaftar terlebih dahulu</p>
        <div class="photos">
            <img src="{{ asset('gambar/carrier.jpeg') }}" alt="carrier">
            <img src="{{ asset('gambar/sepatu.jpg') }}" alt="sepatu">
            <img src="{{ asset('gambar/senter.jpg') }}" alt="senter">
            <img src="{{ asset('gambar/matras.jpg') }}" alt="matras">
            <img src="{{ asset('gambar/sb.jpg') }}" alt="sb">
            <img src="{{ asset('gambar/tenda.jpg') }}" alt="tenda">
            <img src="{{ asset('gambar/kompor.jpg') }}" alt="kompor">
            <img src="{{ asset('gambar/flysheet.jpg') }}" alt="flysheet">
            <img src="{{ asset('gambar/lamputenda.jpg') }}" alt="lamputenda">
            <img src="{{ asset('gambar/ht.png') }}" alt="ht">
        </div>
        <div class="services">
            <div class="service-item">
                <h3>Alat Pribadi</h3>
                <ul>
                    <li>Carrier</li>
                    <li>Sepatu</li>
                    <li>Senter</li>
                    <li>Matras</li>
                    <li>Sleeping Bag</li>
                    <li>Dan lain-lain</li>
                </ul>
            </div>
            <div class="service-item">
                <h3>Alat Kelompok</h3>
                <ul>
                    <li>Tenda Dome</li>
                    <li>Kompor & Nesting</li>
                    <li>Flysheet</li>
                    <li>Lampu Tenda</li>
                    <li>Megaphone</li>
                    <li>Dan lain-lain</li>
                </ul>
            </div>
        </div>

        <div class="contact">
            <h2> <i class="fas fa-phone"></i> Hubungi Kami </h2>
            <p><i class="fab fa-whatsapp"></i> WhatsApp: <a href="https://wa.me/6282127376829" target="_blank">+62 821-2737-6829</a></p>
        </div>

        <div class="map">
            <h2>Lokasi Kami</h2>
            <p><i class="fas fa-map-marker-alt"></i> Alamat: Kampung Cihaneut RT 03 RW 01 Desa Sukamukti Kec. Majalaya Kab. Bandung Jawa Barat (40382)</p>
            <p><i class="fas fa-map-marker-alt"></i> PATOKAN DEPAN MASJID BAITUROHHIM</p>
            <p><i class="fas fa-map"></i> Google Maps: Saba Outdoor Majalaya</p>
            <div class="photos">
                <img src="{{ asset('gambar/gedung.jpeg') }}" alt="gedung">
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.5483497240194!2d110.40911661518152!3d-7.774993994403864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5917c2d53e7b%3A0xb2ffefa7fbc5db5c!2sJl.%20Petualang%20No.%20123%2C%20Bandung%2C%20Indonesia!5e0!3m2!1sen!2sus!4v1624477068785!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </main>
    <footer>
        <p>&copy; {{ date('Y') }} SABA Outdoor Equipment Rent. Semua Hak Dilindungi.</p>
        <p>SEMUA BENTUK TINDAK PIDANA AKAN KAMI SERAHKAN KEPADA PIHAK BERWENANG !</p>
    </footer>
</body>
</html>
