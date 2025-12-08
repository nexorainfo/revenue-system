var quality = 60; //(1 to 100) (recommended minimum 55)
var timeout = 10; // seconds (minimum=10(recommended), maximum=60, unlimited=0 )

function captureRight() {
    try {
        var res = CaptureFinger(quality, timeout);
        if (res.httpStaus) {

console.log(res.data)
            if (res.data.ErrorCode === "0") {
                var Image = "data:image/bmp;base64," + res.data.BitmapData;
                Livewire.emit('setRight', Image, res.data.IsoTemplate, res.data.AnsiTemplate, res.data.IsoImage, res.data.Quality)

            }
        } else {
            alert(res.err);
        }
    } catch (e) {
        alert(e);
    }
    return false;
}

function verifyFinger() {
    try {
        var res = CaptureFinger(quality, timeout);
        if (res.httpStaus) {
            if (res.data.ErrorCode === "0") {
                Livewire.emit('verifyFinger', res.data.IsoTemplate)

            }
        } else {
            alert(res.err);
        }
    } catch (e) {
        alert(e);
    }
    return false;
}

function captureLeft() {
    try {
        var res = CaptureFinger(quality, timeout);
        if (res.httpStaus) {
            if (res.data.ErrorCode === "0") {
                var Image = "data:image/bmp;base64," + res.data.BitmapData;
                Livewire.emit('setLeft', Image, res.data.IsoTemplate, res.data.AnsiTemplate, res.data.IsoImage, res.data.Quality)

            }
        } else {
            alert(res.err);
        }
    } catch (e) {
        alert(e);
    }
    return false;
}

