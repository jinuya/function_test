class Store{
    constructor(){
        this.list = [];
        this.maplist = {};
        this.basketList = [];
        this.drop_area = document.querySelector("#drop_area");
        this.basket_price = document.querySelector("#basket_price");
        this.store_list = document.querySelector("#store_list");
        this.basket_list = document.querySelector("#basket_list");
        this.cho = ["ㄱ","ㄲ","ㄴ",'ㄷ',"ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ",'ㅆ',"ㅇ","ㅈ","ㅉ",'ㅊ',"ㅋ",'ㅌ',"ㅍ","ㅎ"];

        fetch("resources/json/store.json")
        .then(res => res.json())
        .then(data => this.setList(data))
    }

    setList(list){
        this.store_list.innerHTML = "";
        list.forEach(x=>{
            x.price_num = parseInt(x.price.replace(/,/g,""));
            x.num = 1;
            this.MakeStoreItem(x);
        });

        this.list = list;
        this.maplist = this.list.reduce((r,s)=>({...r,[s.id]:s}),{});
        document.querySelector("#search_form").addEventListener("keyup",this.search);
        this.drop_area.addEventListener("drop",this.dropHandle);
        this.drop_area.addEventListener("dragover",this.drop);
        document.querySelector("#basket_sell_btn").addEventListener("click",this.basketSell);
    }

    getCho(word){
        let result = "",idx = null;
        for(let i = 0; i<word.length; i++){
            idx = Math.floor(((word[i].charCodeAt() - 44032)/588));
            if(this.cho[idx] == undefined) result += word[i];
            else result += this.cho[idx];
        }
        return result;
    }

    match(word,keyword){
        let cho = this.getCho(word),flag= false,result = -1;
        for(let i = 0;i<keyword.length;i++){
            flag = false;
            this.cho.find((x)=>{if(x == keyword[i])flag=true;});
            if(flag) result = cho.indexOf(keyword);
            else result = word.indexOf(keyword);
        }

        return result;
    }

    search=e=>{
        let keyword = e.target.value,list = [];
        this.store_list.innerHTML = "";
        if(keyword == "") this.list.forEach(x=>{this.MakeStoreItem(x);});
        else{
            this.list.forEach(x=>{
                let {id,product_name,photo,brand,price,price_num,num} = x;
                let p_idx = this.match(product_name,keyword);
                if(p_idx !== -1) product_name = product_name.substr(0,p_idx)+"<mark>"+product_name.substr(p_idx,keyword.length)+"</mark>"+product_name.substr(p_idx+keyword.length,product_name.length);
                let b_idx = this.match(brand,keyword);
                if(b_idx !== -1) brand = brand.substr(0,b_idx)+"<mark>"+brand.substr(b_idx,keyword.length)+"</mark>"+brand.substr(b_idx+keyword.length,brand.length);
                if(p_idx !== -1 || b_idx !== -1) list.push({id,product_name,photo,brand,price,price_num,num});
            });
            
            if(list.length > 0) list.forEach(x=>{this.MakeStoreItem(x)});
            else this.store_list.innerHTML = "<p id='not_search'>일치하는 상품이 없습니다.</p>";
        }
    }

    MakeStoreItem({id,photo,product_name,brand,price}){

        let dom = document.createElement("div");
        dom.innerHTML = `<div class="card store_card">
                            <img src="resources/images/${photo}" data-id="${id}" title="store_item_img" alt="store_item_img" class="card-img">
                            <div class="card-body">
                                <h5 class="card-title">${product_name}</h5>
                                <p class="card-subtitle text-muted">${brand}</p>
                                <p class="card-text text-right">${price}원</p>
                            </div>
                        </div>`;
        dom.querySelector("img").addEventListener("dragstart",this.drag);
        this.store_list.appendChild(dom.firstChild);
    }

    dropHandle = e=>{
        let id = e.dataTransfer.getData("id");
        this.basketAdd(id);
    }

    drop = e=>{e.preventDefault();}

    drag = e=>{
        let id = e.target.getAttribute("data-id");
        e.dataTransfer.setData("id",id);
    }

    basketAdd(id){
        let flag = false;
        this.basketList.find((x)=>{if(x == id) flag=true;});
        if(flag) return alert("이미 장바구니에 담긴 상품입니다.");
        this.basketList.push(id);
        this.SetBasket();
    }

    SetBasket(){
        this.basket_list.innerHTML = "";
        this.basketList.forEach((x,idx)=>{
            let item = this.maplist[x];
            let dom = document.createElement("tr");
            dom.innerHTML = `<td>${idx+1}</td>
                             <td><img src="resources/images/${item.photo}" alt="basket_img" title="basket_img" class="basket_img"></td>
                             <td>${item.product_name}</td>
                             <td>${item.brand}</td>
                             <td>${item.price}원</td>
                             <td><input type="number" min="1" data-id="${item.id}" value="${item.num}" class="basket_num form-control"></td>
                             <td>${this.price_type((item.price_num * item.num))}원</td>
                             <td><button class="basket_del close" data-idx="${idx}">&times;</button></td>`;
            
            dom.querySelector(".basket_del").addEventListener("click",this.basketDel);
            dom.querySelector(".basket_num").addEventListener("change",this.basketNumChange);
            this.basket_list.appendChild(dom);
        });
        this.basketPrice();
    }

    basketDel=e=>{
        let id = e.target.getAttribute("data-idx");
        this.basketList.splice(id,1);
        this.SetBasket();
    }

    basketNumChange=e=>{
        let val = e.target.value, target = e.target,id = e.target.getAttribute("data-id");
        if(val < 1) val = 1;
        target.value = val;
        this.maplist[id].num = val;
        this.SetBasket();
    }

    price_type(num){
        let result = "",price = num+"";
        while(1){
            if(price.length < 4) break;
            result = price.substr(price.length-3,3)+","+result;
            price = price.substring(0,price.length-3);
        }

        result = price+","+result;
        result = result.substring(0,result.length-1);
        return result;
    }

    basketPrice=e=>{
        let sum = 0;
        this.basketList.forEach(x=>{
            let item = this.maplist[x];
            sum += item.price_num * item.num;
        });
        this.basket_price.innerHTML = this.price_type(sum);
    }

    basketSell=e=>{
        const form = document.basket_form;
        if(form.name.value == "" || form.port.value == "") return alert("내용을 입력해주세요.");
        $("#basket_popup_close").trigger("click");

        // 영수증
        const canvas = document.querySelector("#recepit");
        const ctx = canvas.getContext("2d");

        let offset = 10,fontSize = 15,base_space = 200,sum = 0,list = [],maxproduct = "",maxprice = "",maxnum = "",maxsum = "";

        this.basketList.forEach(x=>{
            let item = this.maplist[x];
            item.sum = this.price_type((item.num * item.price_num));
            sum += (item.num * item.price_num);
            if(item.product_name.length > maxproduct.length) maxproduct = item.product_name;
            if(item.price.length > maxprice.length) maxprice = item.price.length;
            if((item.num+"").length > maxnum.length) maxnum = item.num+"";
            if(item.sum.length > maxsum.length) maxsum = item.sum;
            list.push(item);
        });

        let maxproductwidth = ctx.measureText(maxproduct).width, maxpricewidth = ctx.measureText(maxprice).width, maxnumwidth = ctx.measureText(maxnum).width, maxsumwidth = ctx.measureText(maxsum).width;

        canvas.width = ctx.measureText(maxproduct).width + ctx.measureText(maxprice).width + ctx.measureText(maxnum).width + ctx.measureText(maxsum).width + base_space + (offset*2) + base_space + (fontSize*4);
        canvas.height = (list.length * (offset + fontSize)) + (offset*10);
        ctx.font = fontSize+"px Arial";

        // 그리기 시작
        let left = offset,top = (fontSize*2);

        ctx.fillText("상품명",left,top);
        left += maxproductwidth + fontSize + offset+base_space;
        ctx.fillText("가격",left,top);
        left += maxpricewidth + fontSize + offset +(fontSize*3);
        ctx.fillText("수량",left,top);
        left += maxnumwidth + fontSize + offset+(fontSize*2);
        ctx.fillText("합계",left,top);

        top += offset;

        ctx.beginPath();
        ctx.moveTo(offset,top);
        ctx.lineTo(canvas.width - offset,top);
        ctx.stroke();

        for(let i =0; i<list.length;i++){
            top += fontSize + 5;
            left = offset;
            let item = list[i];

            ctx.fillText(item.product_name,left,top);
            left += maxproductwidth + fontSize + offset+base_space;
            ctx.fillText(item.price+"원",left,top);
            left += maxpricewidth + fontSize + offset+(fontSize*3);
            ctx.fillText(item.num+"개",left,top);
            left += maxnumwidth + fontSize + offset+(fontSize*2);
            ctx.fillText(item.sum+"원",left,top);

        }

        top+=offset;

        ctx.beginPath();
        ctx.moveTo(offset,top);
        ctx.lineTo(canvas.width - offset,top);
        ctx.stroke();

        top += offset+fontSize;
        ctx.fillText(`총합계 : ${this.price_type(sum)}원`,offset,top);
        top += fontSize + 5;
        let now = new Date();
        let info = `구매일시 : ${now.getFullYear()}-${now.getMonth()}-${now.getDay()} ${now.toLocaleTimeString(3)}`;
        ctx.fillText(info,offset,top);

        $("#recepit_open").trigger("click");

        this.maplist = this.list.reduce((r,x)=>({...r,[x.id]:x}),{});
        this.basket_price.innerHTML = "0";
        this.basket_list.innerHTML = "";
        this.basketList = [];
    }
}

window.onload = ()=>{
    let store = new Store();
}