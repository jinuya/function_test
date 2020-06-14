class App{
    constructor(){
        window.addEventListener("click",this.click);
        this.housing_id = null;
        this.review_id = null;
        this.building_post_id = null;
        this.captcha_word = null;
    }

    click=e=>{
        let id = e.target.id,target = e.target;
        if(target.classList.contains("join_open")) this.captcha();
        if(id == "join_btn") this.join();
        if(id == "login_btn") this.login();
        if(target.classList.contains("housing_score_btn")) this.housing_id = target.getAttribute("data-id");
        if(id == "housing_write_btn") this.housing_write();
        if(target.classList.contains("housing_score")) this.housing_addScore(target.getAttribute("data-id"));
        if(target.classList.contains("review_add_btn")) this.review_id = target.getAttribute("data-id");
        if(id == "review_btn") this.reviewWrite();
        if(target.classList.contains("building_request_btn")) this.building_post_id = target.getAttribute("data-id");
        if(id == "building_request_btn") this.building_request();
        if(id == "building_post_send_btn") this.building_post();
        if(target.classList.contains("building_see_btn")) this.building_load(target.getAttribute("data-id"));
    }

    building_load(val){
        $.ajax({
            url:"/building_load",
            method:"post",
            data:{post_id:val},
            success(data){
                let list = JSON.parse(data);
                
                let card = document.createElement("div");
                document.querySelector("#building_request_list").appendChild(card);
            }
        });
    }

    building_post(){
        const form = document.building_post_form;
        if(form.content.value == "" || form.day.value == "") return alert("내용을 입력해주세요.");
        $("#building_post_send").trigger("click");
    }

    building_request(){
        const form = document.building_request_form;
        if(form.price.value == "") return alert("내용을 입력해주세요.");
        form.post_id.value = this.building_post_id;
        $("#building_request_send").trigger("click");
    }

    reviewWrite(){
        const form = document.review_form;
        if(form.score.value == "" || form.price.value == "" || form.content.value == "") return alert("내용을 입력해주세요.");
        form.specialist_id.value = this.review_id;
        $("#review_send").trigger("click");
    }

    housing_write(){
        const form = document.housing_write_form;
        if(form.before_img.value == "" || form.after_img.value == "" || form.content.value == "") return alert("내용을 입력해주세요.");
        $("#housing_write_send").trigger("click")
    }

    housing_addScore(val){
        $.ajax({
            url:"/housingAddScore",
            method:"post",
            data:{post_id:this.housing_id,val:val},
            success(data){
                $("#housing_addScore_close").trigger("click");
                alert("평점등록이 완료되었습니다.");
                location.href = "/housing";
            }
        })
    }

    join(){
        const form = document.join_form;
        if(form.user_id.value == "" || form.user_name.value == "" || form.password.value == "" || form.img.value == "" || form.captcha_word.value == "") return alert("내용을 입력해주세요.");
        if(form.captcha_word.value !== this.captcha_word) return alert('자동입력방지 문자를 잘못 입력하였습니다.');
        $.ajax({
            url:"/joincheck",
            method:"post",
            data:{user_id:form.user_id.value},
            success(data){
                if(JSON.parse(data)){
                    form.user_id.value = "";
                    form.user_name.value = "";
                    form.password.value = "";
                    form.img.value = "";
                    form.captcha_word.value = "";
                    $("#join_send").trigger("click");
                }else return alert("중복되는 아이디입니다. 다른 아이디를 사용해주세요.");
            }
        });
    }

    login(){
        const form = document.login_form;
        if(form.user_id.value == "" || form.password.value == "") return alert("내용을 입력해주세요.");
        $.ajax({
            url:"/logincheck",
            method:"post",
            data:{user_id:form.user_id.value,password:form.password.value},
            success(data){
                if(JSON.parse(data)) $("#login_send").trigger("click");
                else return alert("아이디 또는 비밀번호가 일치하지 않습니다.");
            }
        })
    }

    captcha(){
        this.captcha_word = Math.random().toString(26).substr(2,5);
        console.log(this.captcha_word);
        const canvas = document.querySelector("#captcha");
        const ctx = canvas.getContext("2d");

        canvas.width = 400;
        canvas.height = 100;

        ctx.font = "35px Arial";
        ctx.fillText(this.captcha_word,150,50);
    }
}

window.onload = ()=>{
    let app = new App();
}