let userprogess = [
    {
        id: 1,
        name: "haudang 1",
        point: 30,
        success: 10,
        errors: 2,
    },
    {
        id: 2,
        name: "haudang 2",
        point: 30,
        success: 5,
        errors: 10,
    },
    {
        id: 3,
        name: "haudang 3",
        point: 220,
        success: 5,
        errors: 10,
    }
    ,
    {
        id: 4,
        name: "haudang 4",
        point: 30,
        success: 5,
        errors: 10,
    }
    ,
    {
        id: 2,
        name: "haudang 5",
        point: 400,
        success: 5,
        errors: 10,
    }
    ,
    {
        id: 5,
        name: "haudang 6",
        point: 100,
        success: 5,
        errors: 10,
    }
    ,
    {
        id: 6,
        name: "haudang 7",
        point: 600,
        success: 5,
        errors: 10,
        status: 1,
    },
    {
        id: 7,
        name: "haudang 8",
        point: 20,
        success: 5,
        errors: 10,
    }
    ,
    {
        id: 8,
        name: "haudang 9",
        point: 900,
        success: 5,
        errors: 10,
    }
    ,
    {
        id: 9,
        name: "haudang 10",
        point:80,
        success: 5,
        errors: 10,
    },
    {
        id: 10,
        name: "haudang 11",
        point:1200,
        success: 5,
        errors: 10,
    }
];
let interval;
const getResults = () => {
    window.axios.get(getResultUrl)
        .then(function (response) {

            clearInterval(interval);

            userprogess = response.data;

            updateTable();
            // Cập nhật bảng mỗi giây
            interval = setInterval(updateTable, 1000);
        })
        .catch(function (error) {
            console.log(error);
        });
}

const contentMain = document.querySelector("#content-progess");
class ProgressBar {
  constructor(progressBarId, percentageId, targetPercentage) {
    this.width = 0;
    this.progressBar = document.getElementById(progressBarId);
    this.percentage = document.getElementById(percentageId);
    this.targetPercentage = targetPercentage;
  }

  animate() {
    if (this.width < this.targetPercentage) {
      this.width++;
      this.progressBar.style.width = this.width + "%";
      if (this.percentage) {
        this.percentage.textContent = this.width + "%";
      }
    }
  }
}

function setProgress(accuracy) {
  let progressBar1 = new ProgressBar("progressBar1", "percentage1", accuracy);
  let progressBar2 = new ProgressBar("progressBar2", null, 100 - accuracy);

  function animateProgressBars() {
    requestAnimationFrame(animateProgressBars);
    progressBar1.animate();
    progressBar2.animate();
  }

  animateProgressBars();
}

// Set the accuracy to 10%
setProgress(20);

let totsort = 0;
let errorssort = 0;
function updateTable() {
    let lastSuccessScore = -1;
    if(errorssort < 1){
        for(let i = 0; i < userprogess.length - 1; i++) {
            if(userprogess[i].point < userprogess[i + 1].point) {
              let temp = userprogess[i];
              userprogess[i] = userprogess[i + 1];
              userprogess[i + 1] = temp;
            }
          }
    }else {
        // console.log("returned")
        return;
    }

  const useritem = userprogess
    .map((user, index, array) => {
      let userClass = 'bg-white border-b';

      if (index === 0) {
        if (array.some((u, i) => i > index && user.point < u.point)) {
          userClass += ' errors-row';
          return;
        }
        errorssort++;
      } else if (user.point > lastSuccessScore) {
        userClass += ' errors-row';
        lastSuccessScore = user.point; // cập nhật điểm thành công cao nhất
        // update(arr, id, updatedData)
      } else if (array.some((u, i) => i < index && user.point < u.point)) {
        userClass += ' success-row';
      }
      return `
<tr class="${userClass}">
<th scope="row" class="px-6 py-4 w-[10%] font-medium text-gray-900 whitespace-nowrap">
${index+1}
</th>
<td class="px-6 py-4">
${user.user.name}
</td>
<td class="px-6 py-4">
${user.point}
</td>
<td class="px-6 py-4 w-[50%]">
    <div class="w-[100%] bg-[#f0f0f0] rounded-lg h-12 inline-flex">
        <div class="bg-green-400 inline-flex ml-1.5 mt-1 h-10 rounded-l-lg" style="width: ${
          (user.success / (user.success + user.errors)) * 100
        }%">
            <svg class="mt-2.5 ml-2 w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 17 20">
                <path d="M7.958 19.393a7.7 7.7 0 0 1-6.715-3.439c-2.868-4.832 0-9.376.944-10.654l.091-.122a3.286 3.286 0 0 0 .765-3.288A1 1 0 0 1 4.6.8c.133.1.313.212.525.347A10.451 10.451 0 0 1 10.6 9.3c.5-1.06.772-2.213.8-3.385a1 1 0 0 1 1.592-.758c1.636 1.205 4.638 6.081 2.019 10.441a8.177 8.177 0 0 1-7.053 3.795Z"/>
            </svg>
<!--            <p class="pl-0.5 pt-2 font-bold text-white">${user.success}</p>-->
            <p class="pl-0.5 pt-2 font-bold text-white">5</p>
        </div>
        <div class="bg-red-400 mt-1 h-10 rounded-r-lg" style="width: ${
          (user.errors / (user.success + user.errors)) * 100
        }%"></div>
    </div>
</td>
</tr>
`
    })
    .join("");
    // console.log(useritem);
  document.querySelector("#table-body").innerHTML = useritem;
}

// updateTable();
// // Cập nhật bảng mỗi giây
// setInterval(updateTable, 1000);

getResults();

window.Echo.channel('result-live-score')
    .listen('ResultLiveScoreEvent', function (data) {
    // Xử lý dữ liệu nhận được tại đây
        errorssort = 0;
        getResults();
});
