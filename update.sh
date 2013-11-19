#!/bin/bash
while [ ! -f /tmp/stahp ]
do
  python getjson.py all
  python getjson.py chiptune
  python getjson.py cover
  python getjson.py game
  python getjson.py ocr
done
