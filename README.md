# Tubee

sudo ln -s /usr/bin/python3 /usr/bin/python

youtube-dl --ignore-errors -f bestaudio --extract-audio --audio-format mp3 --audio-quality 0 -o '%(title)s.%(ext)s' "$1"

youtube-dl --extract-audio --audio-format mp3 <video URL>
