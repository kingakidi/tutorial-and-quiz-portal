let quizForm = _("quiz-form");
let showStatus = _("show-status");
let selectedOptions = document.querySelectorAll(".options");
let btnQuizForm = _("btn-quiz-form");
quizForm.onsubmit = function (event) {
  event.preventDefault();
  let userAnswers = [];
  selectedOptions.forEach((element) => {
    if (element.checked) {
      let answer = element.value;
      let quesitonNo = element.getAttribute("data-question");
      let thisAnswerList = {
        qNo: quesitonNo,
        answer,
      };
      userAnswers.push(thisAnswerList);
    }
  });
  //   console.log(quizId);

  //   CHECK FOR EMPTY BEFORE SENDING
  if (quizId > 0 && userAnswers.length > 0) {
    console.log(userAnswers.length);
    //   SEND DATA
    $.ajax({
      url: "./control/actions.php",
      method: "POST",
      data: {
        userAnswers: JSON.stringify(userAnswers),
        quizId,
        submitQuiz: true,
      },
      beforeSend: function () {
        btnQuizForm.disabled = true;
        showStatus.innerHTML = success("Submiting...");
      },
      success: function (data) {
        console.log(data);

        if (
          data.trim() ===
          "<span class='text-success'>QUIZ SUBMITTED SUCCESSFULLY</span>"
        ) {
          alert("Quiz Submitted Successfully");
          btnQuizForm.disabled = true;
          showStatus.innerHTML = data;
          window.location.reload();
        } else {
          showStatus.innerHTML = error(data);
          btnQuizForm.disabled = false;
        }
      },
    });
  } else {
    showStatus.innerHTML = error("Select at least one question");
  }
};
