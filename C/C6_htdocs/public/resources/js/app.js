class App{
    constructor(){
        window.addEventListener("click",this.click);
        window.addEventListener("change",this.change);
        this.captcha_word = null;
        this.housing_id = null;
        this.review_id = null;
        this.building_id = null;
    }

    change = e=>{
        let form = e.target.form,target = e.target.id,value = e.target.value;
        if(form.id == "review_form" && target == "price" && value < 1) form.price.value = 1;
        if(form.id == "review_form" && target == "score" && value < 1) form.score.value = 1;
        if(form.id == "review_form" && target == "score" && value > 5) form.score.value = 5;
    }

    click = e=>{
        let id = e.target.id,target = e.target;
        if(target.classList.contains("join_open")) this.captcha();
        if(id == "login_btn") this.login();
        if(id == "join_btn") this.join();
        if(id == "housing_write_btn") this.housingwrite();
        if(target.classList.contains("housing_score_btn")) this.housing_id = target.getAttribute("data-id");
        if(target.classList.contains("housing_score_value")) this.housing_score(target.getAttribute("data-value"));
        if(id == "review_write_btn") this.review_write();
        if(target.classList.contains("specialist_more_btn")) this.review_id = target.getAttribute("data-id");
        if(target.classList.contains("building_see_id_btn") || target.classList.contains("building_request_id_btn")) this.building_id = target.getAttribute("data-id");
        if(id == "building_post_btn") this.building_post();
        if(id == "building_request_btn") this.building_request();
        if(target.classList.contains("building_request_choose_btn")) this.building_update(target.getAttribute("data-post"),target.getAttribute("data-id"));
        if(target.classList.contains("building_see_id_btn")) this.building_load();
    }

    building_update(post_id,request_id){
        $.ajax({
            url:"/building_update",
            method:"post",
            data:{post_id:post_id,request_id:request_id},
            success(data){
                alert("견적이 선택되었습니다.");
                location.href = "/building";
            }
        })
    }

    building_post(){
        const form = document.building_post_form;
        if(form.day.value == "" || form.content.value == "") return alert("내용을 입력해주세요.");
        document.querySelector("#building_post_send").setAttribute("type","submit");
        $("#building_post_send").trigger("click");
    }

    building_request(){
        const form = document.building_request_form;
        if(form.price.value == "") return alert("내용을 입력해주세요.");
        form.post_id.value = this.building_id;
        document.querySelector("#building_request_send").setAttribute("type","submit");
        $("#building_request_send").trigger("click");
    }

    building_load(){
        $.ajax({
            url:"/building_load",
            method:"post",
            data:{post_id:this.building_id},
            success(data){
                let list = JSON.parse(data);
                document.querySelector("#building_see_list").innerHTML="";
                if(list.length ==0){
                    document.querySelector("#building_see_list").innerHTML = "<p class='text-center p-2 m-0'>받은 견적이 없습니다.</p>";
                }
                else{
                    list.forEach(x=>{
                        let card = document.createElement("div");
                        if(x.status == "requesting"){
                            card.innerHTML = `<div class="card m-2 building_request_load_card">
                                            <div class="card-body">
                                                <h5 class="card-title">${x.user_name}(${x.user_id})</h5>
                                                <hr>
                                                <p class="card-text">비용 : ${x.price}원</p>
                                                <hr>
                                                <button class="float-right btn btn-dark building_request_choose_btn" data-post="${x.post_id}" data-id="${x.id}">선택</button>
                                            </div>
                                        </div>`;
                        }else{
                            card.innerHTML = `<div class="card m-2 building_request_load_card">
                                            <div class="card-body">
                                                <h5 class="card-title">${x.user_name}(${x.user_id})</h5>
                                                <hr>
                                                <p class="card-text">비용 : ${x.price}원</p>
                                                <hr>
                                            </div>
                                        </div>`;
                        }
                        document.querySelector("#building_see_list").appendChild(card.firstChild);
                    });
                }
            }
        });
    }

    review_write(){
        const form = document.review_form;
        if(form.price.value == "" || form.score.value == "" || form.content.value == "") return alert("내용을 입력해주세요.");
        form.specialist_id.value = this.review_id;
        document.querySelector("#review_send").setAttribute("type","submit");
        $("#review_send").trigger("click");
    }

    housingwrite(){
        const form = document.housing_form;
        if(form.before_img.value == "" || form.after_img.value == "" || form.content.value == "") return alert("내용을 입력해주세요.");
        document.querySelector("#housing_write_send").setAttribute("type","submit");
        $("#housing_write_send").trigger("click");
    }

    housing_score(val){
        $.ajax({
            url:"/housingscore",
            method:"post",
            data:{val:val,post_id:this.housing_id},
            success(data){
                setTimeout(()=>{$("#housing_score_close").trigger("click");},100);
                alert("평점등록이 완료되었습니다.");
                location.href = "/housing";
            }
        })
    }

    join(){
        const form = document.join_form;
        if(form.user_id.value == "" || form.user_name.value =="" || form.password.value == "" || form.img.value == "" || form.captcha_word.value == "") return alert("내용을 입력해주세요.");
        if(form.captcha_word.value !== this.captcha_word) return alert("자동입력방지 문자를 잘못 입력하였습니다. ");
        $.ajax({
            url:"/joinCheck",
            method:"post",
            data:{user_id:form.user_id.value},
            success(data){
                if(JSON.parse(data)){
                    document.querySelector("#join_send").setAttribute("type","submit");
                    $("#join_send").trigger("click");
                }
                else return alert("중복되는 아이디입니다. 다른 아이디를 사용해주세요.");
            }
        })
    }

    login(){
        const form = document.login_form;
        if(form.user_id.value == "" || form.password.value == "") return alert("내용을 입력해주세요.");
        $.ajax({
            url:"/loginCheck",
            method:"post",
            data:{user_id:form.user_id.value,password:form.password.value},
            success(data){
                console.log(data);
                if(JSON.parse(data)){
                    document.querySelector("#login_send").setAttribute("type","submit");
                    $("#login_send").trigger("click");
                }
                else return alert("아이디 또는 비밀번호가 일치하지않습니다.");
            }
        });
    }

    captcha(){
        this.captcha_word = Math.random().toString(36).substr(2,5);
        const canvas = document.querySelector("#captcha");
        const ctx = canvas.getContext("2d");

        canvas.width = 400;
        canvas.height = 100;

        ctx.font = "50px Arial";
        ctx.fillText(this.captcha_word,130,70);
    }
}

window.onload = ()=>{
    let app = new App();
}