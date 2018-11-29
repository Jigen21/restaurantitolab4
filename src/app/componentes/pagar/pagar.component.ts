import { Component, OnInit } from '@angular/core';
import { ConexionService } from "../../servicios/conexion.service";
import { JwtHelperService } from "@auth0/angular-jwt";

@Component({
  selector: 'app-pagar',
  templateUrl: './pagar.component.html',
  styleUrls: ['./pagar.component.css']
})
export class PagarComponent implements OnInit {

  public tipo;
  public displayedColumns: string[] = ['nombre', 'precio'];
  public turnos = [];
  public misTurnos;
  public dataSource;
  public nombre;
  public no=false;
  public total=0;

  constructor(private conexion: ConexionService)
   {


    let JWTHelper = new JwtHelperService();
    let token;
    token = JWTHelper.decodeToken(localStorage.getItem("token"));
    
    this.tipo = token.tipo;
    this.nombre=token.correo;

    
 




    this.conexion.traerTotal(this.nombre).subscribe(
      exito => {

        //this.turnos = (exito as any).rta;
        this.turnos = (exito as any);
       // this.misTurnos = this.turnos.filter((value)=> {
       //   return value.id == 1 && value.estado=="tomado"; 
         // return value.correo == token.user;
       // });
       //let no=false;

        //this.dataSource = this.turnos;

        for(let i=0;i<this.turnos.length;i++)
        {
          if(this.turnos[i].estado!="entregado")
          {
              this.no=true;
              //alert("todavia no puede pagar");
              
          }
        }

        if(this.no==false)
        {
          this.dataSource=this.turnos;

          for(let j=0;j<this.dataSource.length;j++)
          {
            //this.total=this.total+this.dataSource[j].precio;
            this.total=this.total+parseInt(this.dataSource[j].precio);
          }


          //alert("ya puede pagar");
        }
        if(this.no==true)
        {
          alert("todavia no puede pagar");
        }



      },
      error => alert("Error: " + JSON.stringify(error))
    );






    }

  ngOnInit() {
  }


  pagar()
  {
    //this.sePuedePagar=true;
    let a=0;

    for(let i=0;i<this.turnos.length;i++)
        {
          if(this.turnos[i].estado=="entregado")
          {
             a++;
              //alert("todavia no puede pagar");
              
          }
        }
        
        if(a==0)
        {
          alert("No puede pagar");
          return;
        }

    if(this.no==false)
    {

      
    this.conexion.pagar(this.nombre).subscribe(
      exito => {

        alert("pago con exito");
        location.href = "./";

      },
      error => alert("Error: " + JSON.stringify(error))
    );


    }



  }

}
