class store{
    constructor(){
        this.list = [];
        this.maplist = {};
        this.basketList = [];
        this.drop_area = document.querySelector("#drop_area");
        this.sellbox = document.querySelector("#sell_price")
        this.basket_list = document.querySelector("#basket_list");
        this.store_list = document.querySelector("#store_list");
        this.search_form = document.querySelector("#search_form");
        this.cho = ["ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ"];

        fetch("resources/json/store.json")
        .then(res => res.json())
        .then(data => this.setting(data))
    }

    reset(){
        fetch("resources/json/store.json")
        .then(res => res.json())
        .then(data => this.setting(data))

        this.sellbox.innerHTML = 0;
        this.basket_list.innerHTML = "";
        this.basketList = [];
    }

    setStoreList(list){
        this.store_list.innerHTML = "";
        if(list.length == 0) this.store_list.innerHTML = `<h5 class="position-absolute text-center w-100">일치하는 상품이 없습니다.</h5>`;
        else list.forEach(x=>{this.MakeItem(x)});
    }

    setting(data){
        data.forEach(x =>{
            x.number = 1;
            x.price_num = parseInt(x.price.replace(/,/g,''));
            this.MakeItem(x);
            this.list.push(x);
        });
        this.maplist = data.reduce((r,x)=>({...r,[x.id]:x}),{});
        this.drop_area.addEventListener("dragover",this.drop);
        this.drop_area.addEventListener("drop",this.dropHandle);
        document.querySelector("#basket_sell").addEventListener("click",this.sellProcess);
        this.search_form.addEventListener("keyup",this.search);
    }

    getcho(word){
        let result = "";
        for(let i = 0; i< word.length; i++){
            let idx = Math.floor((word[i].charCodeAt() - 44032)/588);
            result = result + (this.cho[idx] || word[i]);
        }
        return result;
    }

    match(keyword,data){
        let data_cho = this.getcho(data);
        let keyword_cho = this.getcho(keyword);
        let flag = false,result = false;
        for(let i = 0; i<keyword.length; i++){
            this.cho.find(x=>{if(x==keyword[i]) flag = true});
            if(flag) result = data_cho.indexOf(keyword_cho);
            else result = data.indexOf(keyword);
        }
        return result;
    }

    search = e=>{
        let keyword = e.target.value,search_list = [];
        if(keyword !== ""){
            this.list.forEach(item =>{
                let {id,price,price_num,number,product_name,photo,brand} = item;
                let index = this.match(keyword,item.brand);
                if(index !== -1) brand = brand.substr(0,index)+"<mark class='bg-warning'>"+brand.substr(index,keyword.length)+"</mark>"+brand.substr(index+keyword.length,brand.length);
                let p_idx = this.match(keyword,item.product_name);
                if(p_idx !== -1) product_name = product_name.substr(0,p_idx)+"<mark class='bg-warning'>"+product_name.substr(p_idx,keyword.length)+"</mark>"+product_name.substr(p_idx + keyword.length,product_name.length);
                if(index !== -1 || p_idx !== -1) search_list.push({id,price,price_num,number,product_name,photo,brand});
            });
            this.setStoreList(search_list);
        }else this.setStoreList(this.list);
    }

    MakeItem(item){
        let card = this.makeTemplate(item);
        document.querySelector("#store_list").appendChild(card);
        card.querySelector(".store_img").addEventListener("dragstart",this.dragHandle);
    }

    makeTemplate({id,photo,product_name, brand, price}){
        let dom = document.createElement("div");
        dom.innerHTML = 
        `<div class="card rounded-0">
            <img src="resources/images/${photo}" data-id="${id}" alt="store_img" title="store_img" class="card-img-top store_img" draggable>
            <div class="card-body border-top">
                <h5 class="card-title">${product_name}</h5>
                <p class="card-subtitle">${brand}</p>
                <p class="card-subtitle text-right text-muted">${price}원</p>
            </div>
        </div>`;
        return dom.firstChild;
    }

    dragHandle = e=>{
        let id = e.target.getAttribute("data-id");
        e.dataTransfer.setData("idx",id);
    }

    drop = e=>{e.preventDefault();}

    dropHandle = e=>{
        e.preventDefault();
        let id = e.dataTransfer.getData("idx"),flag = true;
        this.basketList.find((x)=>{if(x == id) flag = false;})
        if(flag) this.AddBasket(id);
        else return alert('이미 장바구니에 담긴 상품입니다.');
    }

    AddBasket(idx){
        this.basket_list.innerHTML = "";
        this.basketList.push(idx);
        this.basketList.forEach((x,idx)=>{this.makeBasketItem(this.maplist[x],idx+1);})
        this.setprice();
    }

    makeBasketItem(item,idx){
        let tr = document.createElement("tr");
        tr.innerHTML = `
        <td>${idx}</td>
        <td><img src="resources/images/${item.photo}" alt="basket_img" title="basket_img" class="basket_item_img"></td>
        <td>${item.product_name}</td>
        <td>${item.brand}</td>
        <td>${item.price}원</td>
        <td><input type="number" class="form-control basket_num" min="1" value="${item.number}" data-id = "${item.id}"></td>
        <td>${this.price_type((item.price_num)*(item.number))}원</td>
        <td><button class="close basket_del" data-idx="${item.idx}">&times;</button></td>`;
        this.basket_list.appendChild(tr);
        tr.querySelector(".basket_num").addEventListener("change",this.checknum);
        tr.querySelector(".basket_del").addEventListener("click",this.delBasket);
    }

    delBasket= e =>{
        let idx = e.target.getAttribute("data-id");
        this.basketList.splice(idx,1);
        this.basket_list.innerHTML = "";
        this.basketList.forEach((x,idx)=>{this.makeBasketItem(this.maplist[x],idx+1)});
        this.setprice();
    }

    checknum = e=>{
        let value = e.target.value,idx = parseInt(e.target.getAttribute("data-id")) - 1,id = e.target.getAttribute("data-id");
        if(value < 1) e.target.value = 1;
        this.maplist[id].number = e.target.value;
        this.list[idx].value = e.target.value;
        this.basket_list.innerHTML = "";
        this.basketList.forEach((x,idx)=>{this.makeBasketItem(this.maplist[x],idx + 1)});
    }

    setprice(){
        let allprice = 0;
        this.basketList.forEach(x=>{allprice += this.maplist[x].price_num;});
        this.sellbox.innerHTML = this.price_type(allprice);
    }

    price_type(str){
        let result = "";
        str = str + "";
        while(1){
            if(str.length < 4) break;
            result = str.substr(str.length - 3 , 3) + "," + result;
            str = str.substr(0,str.length - 3);
        }
        result = str + "," + result;
        result = result.substring(0,result.length - 1);
        return result;
    }

    sellProcess=e=>{
        let form = document.basket_form,reciept_list = [];
        if(form.name.value == "" || form.port.value == "")return alert("내용을 입력해주세요.");
        form.name.value = "";
        form.port.value = "";

        $("#basket_sell_close").trigger("click");
        $("#recepit_btn").trigger("click");

        const canvas = document.querySelector("#recepit");
        const ctx = canvas.getContext("2d");

        let fontsize = 15;
        ctx.font = fontsize+"px Arial";

        let maxname = "",maxprice = "",maxnumber = "",maxallprice = "";
        this.basketList.forEach(x=>{
            let item = this.maplist[x];
            item.sum = (item.price_num) * (item.number);
            reciept_list.push(item);
            if(item.product_name.length > maxname.length) maxname = item.product_name;
            if(item.price.length > maxprice.length) maxprice = item.price;
            if((item.number + "").length > maxnumber.length) maxnumber = item.number+"";
            if((item.sum + "").length > maxallprice.length) maxallprice = item.sum;
        });

        let offset = 10,space = 10;
        let width = ctx.measureText(maxname).width,price_space = ctx.measureText(maxprice).width,number_space = ctx.measureText(maxnumber).width,allprice_space = ctx.measureText(maxallprice).width;
        canvas.height = fontsize * (reciept_list.length + 7);
        canvas.width = width + price_space + number_space + allprice_space + 200;
        let allprice = 0,padding = 0;

        ctx.clearRect(0,0,canvas.width,canvas.height);

        ctx.fillText("품명",offset,fontsize);
        padding = 2* offset + width + space;
        ctx.fillText("가격",padding,fontsize);
        padding += price_space + space;
        ctx.fillText("개수",padding,fontsize);
        padding += number_space + space + space;
        ctx.fillText("합계",padding,fontsize);

        ctx.beginPath();
        ctx.moveTo(offset - 5,fontsize + (fontsize/2));
        ctx.lineTo(canvas.width - offset,fontsize + (fontsize/2));
        ctx.stroke();

        for(let i = 0; i<reciept_list.length; i++){
            let item = reciept_list[i],left = offset,top = ((i+1) * fontsize + offset * i) + fontsize + 5;
            
            ctx.fillText(item.product_name,offset,top);
            let info = `${item.price}원`;
            left = 2 * left + width + space;
            ctx.fillText(info,left,top);
            info = `${item.number}개`;
            left = left + price_space + space;
            ctx.fillText(info,left,top);
            info = `${this.price_type(item.sum)}원`;
            left = left + number_space + space + space;
            ctx.fillText(info,left,top);
            allprice += item.sum;
        }

        let now = new Date();
        let footer_info = `총합계 : ${this.price_type(allprice)}원`,footer_top_space = (reciept_list.length + 1) * fontsize + offset * reciept_list.length + (space * 3);
        let footer_day = `구매일시 : ${now.getFullYear()}-${now.getMonth()}-${now.getDate()} ${now.toLocaleTimeString(3)}`;
        let footer_space = ctx.measureText(footer_info).width;

        ctx.beginPath();
        ctx.moveTo(offset - 5,footer_top_space);
        ctx.lineTo(canvas.width - offset , footer_top_space);
        ctx.stroke();
        
        footer_top_space += fontsize;

        ctx.fillText(footer_day,offset,footer_top_space);
        ctx.fillText(footer_info,(canvas.width - (offset * 2) - footer_space), footer_top_space);

        this.basketList = [];
        this.basket_list.innerHTML = "";

        this.reset();
    }
}

window.onload = ()=>{
    let str = new store();
}