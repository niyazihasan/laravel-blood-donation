req = [];
$(function () {
    $.ajax({
        type: 'GET',
        url: $('#search').data('route'),
        dataType: 'json',
        success: function (data) {
            req = data;
        }
    });
});

function getAsyncResult() {
    return new Promise(function (resolve, reject) {
        let value = document.getElementById("search").value;
        let myJSON = req;
        let z = 0;
        let output = [];
        let outputIDs = [];
        let provCount = [];
        let provName = [];
        let pattern = new RegExp("[а-яА-Я]", "g");
        if (pattern.test(value)) {//checking  for BG letters
            //console.log(myJSON);
            document.getElementById("warning").innerHTML = "";
            for (let i = 0; i < myJSON.length; ++i) {
                for (let j = 0; j < myJSON[i].people.length; ++j) {
                    if (value.length > 0) {
                        document.getElementById("result").innerHTML = "";
                        if (myJSON[i].people[j].name.toLowerCase().search(value.toLowerCase()) != -1 ||
                            myJSON[i].people[j].surname.toLowerCase().search(value.toLowerCase()) != -1 ||
                            myJSON[i].people[j].surname.toLowerCase().search(value.toLowerCase()) != -1) { //matches searching
                            outputIDs.push(myJSON[i].people[j].id);
                            output.push(myJSON[i].people[j].name + " " + myJSON[i].people[j].surname
                                + " (" + myJSON[i].people[j].blood_group + ")");  //creating an array of matches
                            provCount[i] = z + 1;
                            provName[z] = myJSON[i].hospital;
                            ++z;
                        }
                    }
                }
                //console.log(output);
            }
            let newProvName = Array.from(new Set(provName));
            provCount = provCount.filter(Number);
            if (value.length > 0 && output.length > 0) {// printing matched people
                for (let i = 0; i < newProvName.length; ++i) {
                    document.getElementById("result").innerHTML += "<p class='hospital'><b>Болница:" + newProvName[i] + "</b></p>";
                    if (i == 0) {
                        for (let j = 0; j < provCount[0]; ++j) {
                            document.getElementById("result").innerHTML += "<p class='person' id='" + outputIDs[j] + "'  >" + output[j] + "</p>";
                        }
                    } else {
                        for (let j = provCount[i - 1]; j < provCount[i]; ++j) {
                            document.getElementById("result").innerHTML += "<p class='person' id='" + outputIDs[j] + "'  >" + output[j] + "</p>";
                        }
                    }
                }
                document.addEventListener('click', function (e) {
                    let target = e.target;
                    let text = target.textContent;
                    if (target.className.match(/\bperson\b/)) {
                        $('#hiddenVal').attr('value', target.id);
                        value = text;
                        document.getElementById("search").value = value;
                        document.getElementById("result").innerHTML = '';
                    }
                });
            } else {
                document.getElementById("warning").innerHTML += "<b>Няма намерени резултати</b>";
            }
        } else {
            document.getElementById("warning").innerHTML = "<b>Моля въведете букви между а-Я</b>";
            if (value === "") {
                document.getElementById("result").innerHTML = "";
                document.getElementById("warning").innerHTML = "";
            }
        }
    });
}
