CKEDITOR.replace("editor");

let course = _("course");
let topic = _("topic");
let subTopic = _("sub-topic");

let tForm = _("tutorial-form");
let showStatus = _("show-status");

// COURSE ON CHANGE
course.onchange = function () {
  // GET THE VALUE AND SEND FOR SUB TOPIC
  if (clean(course) > 0) {
    $.ajax({
      url: "./control/forms.php",
      method: "POST",
      data: {
        courseId: course.value,
        getTopics: true,
      },
      beforeSend: function () {},
      success: function (data) {
        console.log(data);
        topic.innerHTML = data;
      },
    });
  }
};

tForm.onsubmit = function (event) {
  event.preventDefault();
  let tContent = CKEDITOR.instances.editor.getData();

  // CHECK FOR EMPTY
  if (clean(course) > 0 && clean(topic) > 0 && tContent !== "") {
    var _contents = CKEDITOR.instances.editor.document.getBody().getText();

    if (_contents.trim() === "") {
      showStatus.innerHTML = error("Tutorial Content can't be empty");
    } else {
      $.ajax({
        url: "./control/actions.php",
        method: "POST",
        data: {
          course: course.value,
          topic: topic.value,
          content: tContent,
          // subTopic: subTopic.value,
          registerTutorial: true,
        },
        beforeSend: function () {},
        success: function (data) {
          showStatus.innerHTML = data;
          console.log(data);
        },
      });
    }
  } else {
    showStatus.innerHTML = error("All * fields required");
  }

  // SEND
};
