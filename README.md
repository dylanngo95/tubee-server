# Tubee

## Install environment on ubuntu
```bash
sudo apt-get install youtube-dl
sudo ln -s /usr/bin/python3 /usr/bin/python
sudo apt-get install ffmpeg

# Test download
youtube-dl --ignore-errors -f bestaudio --extract-audio --audio-format mp3 --audio-quality 0 -o '%(title)s.%(ext)s' "$1"
youtube-dl --extract-audio --audio-format mp3 <Video URL>
```
## How to use application
```bash
mkdir -p pub/static/mp3 var/log
# Install php 8.1

# Run application
php pub/index.php

# Download video with url: https://www.youtube.com/watch?v=akeytNVcIy4
http://localhost:8080/download/akeytNVcIy4

# MP3 file will be save to pub/static/mp3
```
Thanks