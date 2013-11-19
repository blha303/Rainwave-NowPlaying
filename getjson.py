from urllib2 import urlopen
from urllib import urlencode
from json import loads, dumps
from re import search
from time import sleep
from sys import argv, exit


def all():
    apikey = search("PRELOADED_APIKEY = '(.*?)'", urlopen("http://all.rainwave.cc").read()).group(1)
    data = loads(urlopen("http://all.rainwave.cc/sync/5/init",
                         data=urlencode({'refresh': 'full',
                                        'user_id': '1',
                                        'key': apikey,
                                        'in_order': 'true'}
                                        )).read())
    return data[3]["sched_current"]["song_data"][0]


def chiptune():
    apikey = search("PRELOADED_APIKEY = '(.*?)'", urlopen("http://chiptune.rainwave.cc").read()).group(1)
    data = loads(urlopen("http://chiptune.rainwave.cc/sync/4/init",
                         data=urlencode({'refresh': 'full',
                                        'user_id': '1',
                                        'key': apikey,
                                        'in_order': 'true'}
                                        )).read())
    return data[3]["sched_current"]["song_data"][0]


def cover():
    apikey = search("PRELOADED_APIKEY = '(.*?)'", urlopen("http://cover.rainwave.cc").read()).group(1)
    data = loads(urlopen("http://cover.rainwave.cc/sync/3/init",
                         data=urlencode({'refresh': 'full',
                                        'user_id': '1',
                                        'key': apikey,
                                        'in_order': 'true'}
                                        )).read())
    return data[3]["sched_current"]["song_data"][0]


def ocr():
    apikey = search("PRELOADED_APIKEY = '(.*?)'", urlopen("http://ocr.rainwave.cc").read()).group(1)
    data = loads(urlopen("http://ocr.rainwave.cc/sync/2/init",
                         data=urlencode({'refresh': 'full',
                                        'user_id': '1',
                                        'key': apikey,
                                        'in_order': 'true'}
                                        )).read())
    return data[3]["sched_current"]["song_data"][0]


def game():
    apikey = search("PRELOADED_APIKEY = '(.*?)'", urlopen("http://game.rainwave.cc").read()).group(1)
    data = loads(urlopen("http://game.rainwave.cc/sync/1/init",
                         data=urlencode({'refresh': 'full',
                                        'user_id': '1',
                                        'key': apikey,
                                        'in_order': 'true'}
                                        )).read())
    return data[3]["sched_current"]["song_data"][0]


if __name__ == "__main__":
    if len(argv) < 2:
        print "Needs an argument."
        sleep(10)
        exit()
    if argv[1] == "all":
        data = all()
        with open('all.json', 'w') as f:
            f.write(dumps(data))
        print "done all"
        exit()
    if argv[1] == "chiptune":
        data = chiptune()
        with open('chiptune.json', 'w') as f:
            f.write(dumps(data))
        print "done chiptune"
        exit()
    if argv[1] == "cover":
        data = cover()
        with open('cover.json', 'w') as f:
            f.write(dumps(data))
        print "done cover"
        exit()
    if argv[1] == "game":
        data = game()
        with open('game.json', 'w') as f:
            f.write(dumps(data))
        print "done game"
        exit()
    if argv[1] == "ocr":
        data = ocr()
        with open('ocr.json', 'w') as f:
            f.write(dumps(data))
        print "done ocr, sleeping"
        print "------------"
        sleep(5)
        exit()
    print "No valid arg given: all, chiptune, game, cover, ocr"
    sleep(10)
    exit()
