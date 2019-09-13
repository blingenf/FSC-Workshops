import flask
import time
import os
import binascii

app = flask.Flask(__name__)
app.secret_key = b'\xa37\xd8\x16r7\xfb\xcf|\x8f\xe9\x16_\x0b'
app.config['MAX_CONTENT_LENGTH'] = 2105344

@app.route('/')
def home():
    user_agent = flask.request.headers.get('User-Agent')
    if "Edge" in user_agent:
        browser = "Edge"
    elif "Firefox" in user_agent:
        browser = "Firefox"
    elif "Chrome" in user_agent:
        browser = "Chrome"
    elif "Safari" in user_agent:
        browser = "Safari"
    else:
        browser = "Unknown"

    if "Linux" in user_agent:
        os = "Linux"
    elif "Windows" in user_agent:
        os = "Windows"
    elif "Mac" in user_agent:
        os = "Mac"
    else:
        os = "Unknown"

    return flask.render_template('index.html', browser=browser, os=os)

@app.route('/get')
def get():
    return flask.render_template('get.html')

@app.route('/art')
def art():
    get_params = flask.request.args
    art_map = {
      "marc" : {
        "1" : "blue_horse_I.jpg",
        "2" : "little_blue_horse.jpg",
        "3" : "two_blue_horses.jpg",
        "4" : "red_and_blue_horse.jpg",
        "5" : "two_horses_red_and_blue.jpg",
        "6" : "little_blue_horses.jpg",
        "7" : "large_blue_horses.jpg",
        "8" : "tower_blue_horses.jpg",
        "9" : "dreaming_horse.jpg",
        "10" : "st_julian_the_hospitaler.jpg",
        "11" : "sleeping_animals.jpg",
        "12" : "horse_and_dog.jpg",
        "13" : "two_horses.jpg",
      },
      "macke" : {
        "1" : "kairouan_III.jpg",
        "2" : "kandern.jpg",
        "3" : "tegernsee.jpg",
      },
      "kandinsky" : {
        "1" : "blue_rider.jpg",
        "2" : "composition_6.jpg",
        "3" : "concentric_circles.jpg",
      }
    }
    if "artist" in get_params and "work" in get_params:
        try:
            file = art_map[get_params["artist"]][get_params["work"]]
            folder = "static/images/" + get_params["artist"]
        except KeyError:
            return flask.redirect('/get')
    else:
        return flask.redirect('/get')

    return flask.send_from_directory(folder, file)

@app.route('/post')
def post():
    return flask.render_template('post.html')

# This is broken
# oops
@app.route('/upload', methods=['GET', 'POST'])
def upload():
    if flask.request.method == 'POST' and 'image' in flask.request.files:
        file = flask.request.files['image']
        extention = file.filename.rsplit('.', 1)[1].lower()
        if extention in ["jpg", "png"]:
            filename = binascii.hexlify(os.urandom(10)).decode() \
                       + "." + extention
            path = "uploads/" + filename
            file.save(path)
            return flask.render_template('post.html', image_path=path)
        else:
            return flask.render_template('post.html', error="invalid extention")
        return flask.redirect('/post')
    else:
        return flask.redirect('/post')

@app.route('/uploads/<file>')
def access_upload(file):
    return flask.send_from_directory('uploads', file)

@app.route('/cookies', methods=['GET', 'POST'])
def cookies():
    if 'score' in flask.request.cookies:
        score = flask.request.cookies["score"]
        if flask.request.method == "POST":
            score = str(int(score)+1)
        response = flask.make_response(flask.render_template('cookies.html',
                                       score=score))
        response.set_cookie('score', score)
    else:
        response = flask.make_response(flask.render_template('cookies.html',
                                       score="0"))
        response.set_cookie('score', "0")
    return response

if __name__ == '__main__':
    app.static_folder = './static'
    app.template_folder = './templates'

    app.run(host='127.0.0.1', debug=True)
