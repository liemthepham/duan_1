
<head>
    <style>
.body {

    display: flex;
    justify-content: center;
    color: #fff;
    width: 100%;
    margin: 0;
}



.contact-form {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 16px;
    padding: 40px 50px;
    max-width: 480px;
    width: 100%;
    box-shadow: 0 8px 32px rgba(0,0,0,0.25);
    box-sizing: border-box;
     margin: 40px auto;  /* căn giữa theo ngang */
    max-width: 480px;
}

.contact-form h2 {
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
    text-align: center;
    letter-spacing: 0.05em;
}

.contact-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    font-size: 1rem;
    color: #f0f0f0cc;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 14px 18px;
    border-radius: 12px;
    border: none;
    font-size: 1rem;
    margin-bottom: 20px;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    box-shadow: inset 0 0 8px rgba(255,255,255,0.15);
    transition: background 0.3s ease, box-shadow 0.3s ease;
    resize: none;
}



.contact-form button {
    width: 100%;
    padding: 16px 0;
    background: #ff416c;
    background: linear-gradient(45deg, #ff416c, #ff4b2b);
    border: none;
    border-radius: 14px;
    color: white;
    font-weight: 700;
    font-size: 1.25rem;
    cursor: pointer;
    transition: background 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 75, 43, 0.6);
}

.contact-form button:hover {
    background: linear-gradient(45deg, #ff4b2b, #ff416c);
    box-shadow: 0 6px 25px rgba(255, 75, 43, 0.9);
}

@media (max-width: 480px) {
    .contact-form {
        padding: 30px 25px;
    }
    .contact-form h2 {
        font-size: 2rem;
    }
    .contact-form button {
        font-size: 1.1rem;
        padding: 14px 0;
    }
}

    </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

    <div class="contact-form" role="main">
        <h2>Liên hệ với chúng tôi</h2>
        <form method="POST" action="#">
            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name" required placeholder="Nhập họ và tên của bạn">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Nhập email của bạn">

            <label for="message">Nội dung:</label>
            <textarea id="message" name="message" required placeholder="Nhập nội dung liên hệ"></textarea>

            <button type="submit">Gửi</button>
        </form>
    </div>
    <?php include_once __DIR__ . '/footer.php'; ?>
</body>

