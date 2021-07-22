let course = _("course");
let topic = _("topic");
let qType = _("question-type");
let showQuestion = _("show-question");
let setQuiz = _("set-quiz");

// let editorQuestion = _('')
CKEDITOR.replace("question");
// ON COURSE CHANGE
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
        // console.log(data);
        topic.innerHTML = data;
      },
    });
  }
};

// LOADING OPTIONS TYPE
qType.onchange = function () {
  let qValue = qType.value;
  if (qValue.trim() !== "") {
    if (qValue !== "") {
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          quizOpitonType: qValue,
        },
        beforeSend: function () {
          showQuestion.innerHTML = success("Loading...");
        },
        success: function (data) {
          showQuestion.innerHTML = data;
          //   console.log(data);
        },
        complete: function () {
          globalThis.questionType = _("type").value;
          if (questionType === "essay") {
            //   GIVE ALL THE TEXTAREA A FORMATTNG
            let textareaArray = document.querySelectorAll(".question-options");
            textareaArray.forEach((element) => {
              id = element.id;
              CKEDITOR.replace(id);
            });
            // END OF TEXTAREA TEXT EDITOR

            // ON SUBMIT CHECK
            setQuiz.onsubmit = function (event) {
              event.preventDefault();
              let question = CKEDITOR.instances.question.getData();
              let option1 = CKEDITOR.instances.option1.getData();
              let option2 = CKEDITOR.instances.option2.getData();
              let option3 = CKEDITOR.instances.option3.getData();
              let option4 = CKEDITOR.instances.option4.getData();
              // GET THE TEXT OF OPTIONS
              let questionText = CKEDITOR.instances.question.document
                .getBody()
                .getText();
              globalThis.optionText1 = CKEDITOR.instances.option1.document
                .getBody()
                .getText();

              globalThis.optionText2 = CKEDITOR.instances.option2.document
                .getBody()
                .getText();
              // console.log(optionText2);
              // console.log(optionText2);
              globalThis.optionText3 = CKEDITOR.instances.option3.document
                .getBody()
                .getText();
              globalThis.optionText4 = CKEDITOR.instances.option4.document
                .getBody()
                .getText();
              let rightAnswer = _("right-answer");
              let showStatus = _("show-status");
              if (
                clean(course) > 0 &&
                clean(topic) > 0 &&
                optionText1 !== "" &&
                optionText2 !== "" &&
                clean(rightAnswer) > 0 &&
                questionText !== ""
              ) {
                // CHECK IF SELECTED RIGHT ANSWER OPTION IS NOT EMPTY
                globalThis.sRightAnswer = `optionText${rightAnswer.value}`;
                let rightAnswerText = window[sRightAnswer];
                // console.log(rightAnswerText);
                if (rightAnswerText.trim() !== "") {
                  // SEND
                  $.ajax({
                    url: "./control/actions.php",
                    method: "POST",
                    data: {
                      question: question,
                      option1: option1,
                      option2: option2,
                      option3: option3,
                      option4: option4,
                      rightAnswer: rightAnswer.value,
                      course: course.value,
                      topic: topic.value,
                      qType: qType.value,
                      sendEssayQuesiton: true,
                    },
                    beforeSend: function () {},
                    success: function (data) {
                      showStatus.innerHTML = data;
                      // console.log(data);
                    },
                  });
                } else {
                  showStatus.innerHTML = error("Right Answer can't be empty");
                }
              } else {
                showStatus.innerHTML = error("All * fields required");
              }
            };
          } else if (questionType === "yesno") {
            setQuiz.onsubmit = function (event) {
              event.preventDefault();
              // console.log("This is yesno ");
              let question = CKEDITOR.instances.question.getData();
              let questionText = CKEDITOR.instances.question.document
                .getBody()
                .getText();
              let userAnswer = _("right-answer");
              let showStatus = _("show-status");

              // CHECK FOR EMPTY FIELDS
              console.log(userAnswer);
              if (
                clean(userAnswer) > 0 &&
                questionText.trim() !== "" &&
                clean(topic) > 0 &&
                clean(course) > 0
              ) {
                // SEND DATA
                $.ajax({
                  url: "./control/actions.php",
                  method: "POST",
                  data: {
                    userAnswer: userAnswer.value,
                    question,
                    course: course.value,
                    topic: topic.value,
                    qType: qType.value,
                    sendYesnoQuestion: true,
                  },
                  beforeSend: function () {},
                  success: function (data) {
                    console.log(data);
                    showStatus.innerHTML = data;
                  },
                });
              } else {
                showStatus.innerHTML = error("All fields required ");
              }
              // SEND IF NOT EMPTY
            };
          } else if (questionType === "truthy") {
            setQuiz.onsubmit = function (event) {
              event.preventDefault();
              console.log("This is yesno ");
              let question = CKEDITOR.instances.question.getData();
              let questionText = CKEDITOR.instances.question.document
                .getBody()
                .getText();
              let userAnswer = _("right-answer");
              let showStatus = _("show-status");

              // CHECK FOR EMPTY FIELDS
              console.log(userAnswer);
              if (
                clean(userAnswer) > 0 &&
                questionText.trim() !== "" &&
                clean(topic) > 0 &&
                clean(course) > 0
              ) {
                // SEND DATA
                $.ajax({
                  url: "./control/actions.php",
                  method: "POST",
                  data: {
                    userAnswer: userAnswer.value,
                    question,
                    course: course.value,
                    topic: topic.value,
                    qType: qType.value,
                    sendTruthyQuestion: true,
                  },
                  beforeSend: function () {},
                  success: function (data) {
                    console.log(data);
                    showStatus.innerHTML = data;
                  },
                });
              } else {
                showStatus.innerHTML = error("All fields required ");
              }
              // SEND IF NOT EMPTY
            };
          }
        },
      });
    }
  }
};
