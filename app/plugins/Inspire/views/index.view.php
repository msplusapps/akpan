<div style="
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 20px;
    background: linear-gradient(135deg, #6366f1, #ec4899);
    font-family: 'Segoe UI', Tahoma, sans-serif;
    color: #fff;
    box-sizing: border-box;
    text-align: center;
">
    <div style="
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        padding: 30px;
        border-radius: 20px;
        max-width: 600px;
        width: 100%;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        overflow-wrap: break-word;
    ">
        <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px; color: #fff;">
            ✨ Today's Motivation ✨
        </h2>
        <blockquote style="
            font-size: 28px;
            font-style: italic;
            line-height: 1.5;
            margin: 20px 0;
            color: #fff;
            word-wrap: break-word;
        ">
            "<?= htmlspecialchars($quote['message']) ?>"
        </blockquote>
        <p style="font-size: 20px; margin-bottom: 30px; color: #f0f0f0;">
            <?= $quote['author'] ? '- ' . htmlspecialchars($quote['author']) : '' ?>
        </p>
        <a href="" style="
            background: #fff;
            color: #4f46e5;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-block;
            max-width: 100%;
        " onmouseover="this.style.background='#4f46e5'; this.style.color='#fff';"
           onmouseout="this.style.background='#fff'; this.style.color='#4f46e5';">
            🔄 New Quote
        </a>
    </div>
</div>