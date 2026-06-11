from pathlib import Path
from urllib.request import Request, urlopen


LOGO_URL = "https://www.ur.edu.pl/files/ur/import/private/25/UR;-niebieskie-do-pobrania.png"
OUT_PATH = Path("/workspace/docs/logo_ur_official.png")


if __name__ == "__main__":
    OUT_PATH.parent.mkdir(parents=True, exist_ok=True)
    request = Request(
        LOGO_URL,
        headers={
            "User-Agent": "Mozilla/5.0 (X11; Linux x86_64)",
            "Referer": "https://www.ur.edu.pl/",
        },
    )
    with urlopen(request) as response:
        OUT_PATH.write_bytes(response.read())
    print(f"Pobrano logo UR do: {OUT_PATH}")
