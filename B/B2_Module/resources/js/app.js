class App{
    constructor(){
        this.list = [];
        this.maplist = {};
        this.basket_list = [];
        this.basket_area = document.querySelector("#basket_list_area");
        this.item_list = document.querySelector("#item_list");
        this.drop_area = document.querySelector("#drop_area");
        this.all_price_box = document.querySelector("#basket_price");
        this.sell_btn = document.querySelector("#basket_sell");
        this.search_form = document.querySelector("#search_form");
        this.cho = ["ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ"];

        // json 파일 불러오기
        fetch("resources/json/store.json")
        .then(res => res.json())
        .then(data => this.setting(data));
    }

    getCho(name){
        let result = "";
        for(let i = 0; i < name.length; i++){
            let idx = Math.floor((name[i].charCodeAt() - 44032)/588); // 초성분리
            result = result + (this.cho[idx] || name[i]);
        }
        return result;
    }

    setting(item){
        this.item_list.innerHTML="";
        this.list = item;
        item.forEach(x=>{
            x.price_num = parseInt(x.price.replace(/,/g,''));
            x.num = 1;
            this.MakeItem(x);
        });
        this.maplist = item.reduce((r,x)=>({...r,[x.id]:x}));
        this.drop_area.addEventListener("drop",this.dropHandle);
        this.drop_area.addEventListener("dragover",this.drop);
        if(!this.basket_list.length) this.basket_area.innerHTML = "";
        else this.basket_list.forEach((x,idx)=>{this.MakeBasketItem(x,idx)});
        this.sell_btn.addEventListener("click",this.makeRecipe);
        this.search_form.addEventListener("keyup",this.search);
    }

    search = e =>{
        this.item_list.innerHTML = "";
        let keyword = e.target.value;
        if(keyword.length == 0) this.list.forEach(x=>{this.MakeItem(x);});
        else{
            let newList = [];
            this.list.forEach((data) =>{
                let {id,price,price_num,num,product_name,photo,brand} = data;
                let index = this.match(keyword,data.brand);
                if(index !== -1) brand = brand.substr(0,index)+"<mark>"+brand.substr(index,keyword.length)+"</mark>"+brand.substr(index+keyword.length,brand.length);
                let p_idx = this.match(keyword,data.product_name);
                if(p_idx !== -1) product_name = product_name.substr(0,p_idx)+"<mark>"+product_name.substr(p_idx,keyword.length)+"</mark>"+product_name.substr(p_idx+keyword.length,product_name.length);
                if(index !== -1 || p_idx !== -1) newList.push({id,price,price_num,num,product_name,photo,brand});
            });

            if(newList.length == 0) this.item_list.innerHTML = '<h4 id="search_notfound">일치하는 상품이 없습니다.</h4>';
            else newList.forEach(x=>{this.MakeItem(x);});
        }
    }

    match(keyword,data){
        let data_Cho = this.getCho(data);
        let keyword_Cho = this.getCho(keyword);
        let flag = false,result = false;
        for(let i = 0; i<keyword.length; i++){
            this.cho.find(x=>{if(x == keyword[i]) flag = true});
            if(flag) result = data_Cho.indexOf(keyword_Cho);
            else result = data.indexOf(keyword);
        }
        return result;
    }

    makeRecipe= e=>{
        let form = document.basket_form;
        if(form.basket_name.value == "" || form.basket_port.value == "") return alert("내용을 입력해주세요.");
        if(this.basket_list.length == 0) return alert("구매할 상품이 없습니다.");
        $("#basket_sell_close").trigger("click");
        $("#receipt_open").trigger("click");

        // 영수증 출력
        const canvas = document.querySelector("#receipt");
        const ctx = canvas.getContext("2d");
        let fontSize = 25,receipt_list = [],item;
        ctx.font = fontSize + "px Arial";
        let maxString = "",price_max = "" , number_max = "" , all_price_max = "";
        if(this.basket_list.length > 0){
            this.basket_list.forEach(x =>{
                item = this.list[x];
                item.sum = item.num * item.price_num;
                receipt_list.push(item);
                if(item.product_name.length > maxString.length) maxString = item.product_name;
                if((item.price+"").length > price_max.length) price_max = item.price+"";
                if((item.num+"").length > number_max.length) number_max = item.num + "";
                if((item.sum+"").length > all_price_max.length) all_price_max = item.sum+"";
            });
        }

        let offset = 10,space = 10;
        let width = ctx.measureText(maxString).width;
        let price_space = ctx.measureText(price_max).width;
        let number_space = ctx.measureText(number_max).width;
        let allprice_space = ctx.measureText(all_price_max).width;
        canvas.height = fontSize * (receipt_list.length + 5);
        canvas.width = width + price_space + number_space + allprice_space + 50;
        let allprice = 0;
        ctx.clearRect(0,0,canvas.width,canvas.height);
        // 영수증 제목
        ctx.fillText("품명",offset,fontSize);
        ctx.fillText("가격",2*offset + width + space,fontSize);
        ctx.fillText("개수",2*offset + width + price_space + space,fontSize);
        ctx.fillText("합계",2*offset + width + price_space + number_space + space + space + space,fontSize);

        ctx.beginPath();
        ctx.moveTo(offset - 5,fontSize + (fontSize/2));
        ctx.lineTo(canvas.width - offset,fontSize + (fontSize/2));
        ctx.stroke();

        // 영수증 그리기 시작
        for(let i = 0; i<receipt_list.length; i++){
            let left = offset,top = ((i+1) * fontSize + offset * i) + fontSize + 5;
            let item = receipt_list[i];
            ctx.fillText(item.product_name,offset,top)//제품명
            let infoText = `${item.price}원`;
            left = 2*left + width + space;
            ctx.fillText(infoText,left,top);
            infoText = `${item.num}개`;
            left += price_space + space;
            ctx.fillText(infoText,left,top);
            infoText = `${item.sum}원`;
            left += number_space + space;
            ctx.fillText(infoText,left,top);
            allprice += item.sum;
        }

        let now = new Date();
        let last_day = `총합계 : ${this.price_type(allprice)}원`,last_top_space = (receipt_list.length+1)*fontSize + offset * receipt_list.length+(space*3);
        let lastString = `구매일시 : ${now.getFullYear()}-${now.getMonth()}-${now.getDate()} ${now.toLocaleTimeString(3)}`;
        let lastString_space = ctx.measureText(last_day).width;

        ctx.beginPath();
        ctx.moveTo(offset - 5,last_top_space);
        ctx.lineTo(canvas.width - offset,last_top_space);
        ctx.stroke();

        last_top_space += fontSize / 2;

        ctx.fillText(lastString,offset,last_top_space);
        ctx.fillText(last_day,(canvas.width - (offset*2) - lastString_space),last_top_space);
        this.basket_list = [];
        this.basket_area.innerHTML = "";
        this.All_Price();
    }

    MakeItem(data){
        let card = document.createElement("div");
        card.setAttribute("data-id",data.id);
        card.classList.add("card");
        card.classList.add("overflow-hidden");
        card.classList.add("store_item")
        card.innerHTML = `<div class="card-img card-img-box">
                                <img src="resources/images/${data.photo}" class="item_img title="store_item_img" alt="store_item_img" draggable="true">
                            </div>
                            <div class="card-body border border-top">
                                <h4 class="card-title">${data.product_name}</h4>
                                <h5 class="card-subtitle text-muted">${data.brand}</h5>
                                <p class="float-right card-text">${data.price} 원</p>
                            </div>`;
        card.querySelector(".item_img").addEventListener("dragstart",this.dragHandle);
        this.item_list.appendChild(card);
    }

    dragHandle= e =>{
        let id = e.target.parentElement.parentElement.getAttribute("data-id");
        e.dataTransfer.setData("idx",id-1);
    }

    dropHandle = e =>{
        e.preventDefault()
        let id = e.dataTransfer.getData("idx");
        if(id !== "") this.basketIn(id);
    }
    drop = e =>{e.preventDefault();}

    basketIn(id){
        let flag = this.basket_list.find((x)=>{if(x == id) return 1});
        if(flag) return alert("이미 장바구니에 담긴 상품입니다.");
        this.basket_list.push(id);
        this.Basket_reset();
    }
    
    MakeBasketItem(data,idx){
        let item = this.list[data];
        let tr = document.createElement("tr");
        tr.setAttribute("data-id",item.id);
        tr.innerHTML = `<th scope="row" class="basket_num">${idx+1}</th>
                        <td><img src="resources/images/${item.photo}" alt="item_img" title="item_img"></td>
                        <td>${item.product_name}</td>
                        <td>${item.brand}</td>
                        <td>${item.price}원</td>
                        <td><input type="number" data-id="${item.id}" data-idx="${idx}" min="1" class="form-control basket_number_input" value="${item.num}" ></td>
                        <td>${this.price_type((item.num)*(item.price_num))}원</td>
                        <td><button class="close basket_del" data-id="${item.id}" data-idx="${idx}">&times;</button></td>`;
        tr.querySelector(".basket_number_input").addEventListener("change",this.item_number);
        tr.querySelector(".basket_del").addEventListener("click",this.basket_del);
        this.basket_area.appendChild(tr);
        this.All_Price();
    }

    basket_del = e=>{
        let idx = e.target.getAttribute("data-idx");
        this.basket_list.splice(idx,1);
        this.Basket_reset();
        this.All_Price();
    }

    item_number = e =>{
        let id = this.basket_list[e.target.getAttribute("data-idx")],val = e.target.value;
        let item = this.list[id];
        if(val < 1) val = 1;
        e.target.value = val;
        item.num = val;
        this.All_Price();
        this.Basket_reset();
    }

    Basket_reset(){this.basket_area.innerHTML="";this.basket_list.forEach((x,idx)=>{this.MakeBasketItem(x,idx);})}

    All_Price(){
        let result = 0;
        if(this.basket_list.length !== 0){
            this.basket_list.forEach(x =>{
                let item = this.list[x];
                result += item.price_num * item.num;
            });
        }
        this.all_price_box.innerHTML = this.price_type(result);
    }

    price_type(str){
        let result = "";
        str = str + "";
        while(1){
            if(str.length < 4) break;
            result = str.substr(str.length - 3 , 3) + "," + result;
            str = str.substr(0,str.length-3);
        }
        result = str+","+result;
        result = result.substring(0,result.length-1);
        return result;
    }
}

window.onload = () =>{let app = new App();}