from pathlib import Path

from PIL import Image, ImageDraw, ImageFont


def create_logo(output_path: Path) -> None:
    width, height = 900, 320
    image = Image.new("RGBA", (width, height), (255, 255, 255, 0))
    draw = ImageDraw.Draw(image)

    # Background rounded rectangle
    draw.rounded_rectangle(
        [(8, 8), (width - 8, height - 8)],
        radius=48,
        fill=(22, 34, 75, 255),
        outline=(147, 51, 234, 255),
        width=8,
    )

    # Accent circle
    draw.ellipse([(42, 42), (278, 278)], fill=(168, 85, 247, 255))
    draw.ellipse([(82, 82), (238, 238)], fill=(255, 255, 255, 245))

    try:
        font_big = ImageFont.truetype("DejaVuSans-Bold.ttf", 92)
        font_mid = ImageFont.truetype("DejaVuSans-Bold.ttf", 56)
        font_small = ImageFont.truetype("DejaVuSans.ttf", 30)
    except OSError:
        font_big = ImageFont.load_default()
        font_mid = ImageFont.load_default()
        font_small = ImageFont.load_default()

    # UR mark
    draw.text((107, 107), "UR", font=font_mid, fill=(49, 46, 129, 255))

    # Title text
    draw.text((320, 70), "Uniwersytet Rzeszowski", font=font_mid, fill=(255, 255, 255, 255))
    draw.text((322, 156), "Projekt: BillsBuddy", font=font_big, fill=(236, 72, 153, 255))
    draw.text((324, 252), "Dokumentacja projektowa", font=font_small, fill=(226, 232, 240, 255))

    output_path.parent.mkdir(parents=True, exist_ok=True)
    image.save(output_path, format="PNG")


if __name__ == "__main__":
    create_logo(Path("/workspace/docs/logo_ur.png"))
    print("Wygenerowano /workspace/docs/logo_ur.png")
