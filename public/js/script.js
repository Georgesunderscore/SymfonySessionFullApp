

function onClickBtnAddSessionModule(e){
  e.preventDefault()
  //event.stopPropagation();
    alert("test")
    const nbrjrsval = document.querySelector('.nbrjrs').value;
    const url = this.getAttribute('href')
    axios.get(url+ "&nbrjrs="+nbrjrsval).then(function (response) {
        console.log(response.data)
        // const data = response.data
    })
// 

}



// const el = document.getElementById("js-add-session-module");
const el = document.querySelector('.js-add-session-module');
el.addEventListener("click", onClickBtnAddSessionModule);


