import { Component, OnInit } from '@angular/core';
import { JwtHelperService } from "@auth0/angular-jwt";

import { ConexionService } from "../../servicios/conexion.service";

@Component({
  selector: 'app-hacer-pedido',
  templateUrl: './hacer-pedido.component.html',
  styleUrls: ['./hacer-pedido.component.css']
})
export class HacerPedidoComponent implements OnInit {

 // public displayedColumns: string[] = ['nombre', 'tipo','precio','tiempo','imagen','cantidad'];
 public displayedColumns: string[] = ['nombre', 'precio','tiempo','imagen','cantidad'];
  public turnos = [];
  public misTurnos;
  public dataSource = [];
  public valor=3;
  public nombre;

  constructor(private conexion: ConexionService) 
  { 

    
    let JWTHelper = new JwtHelperService();
    let token;
    token = JWTHelper.decodeToken(localStorage.getItem("token"));
    
    this.nombre=token.correo;

    this.conexion.estoySentado(this.nombre).subscribe(
      exito => {

      if(exito=="no")
       {
         alert("Primero sientese en una mesa");
         return;
         
       }

       if(exito=="si")
       {

          this.conexion.Pedidos().subscribe(
          exito => {

          
            this.turnos = (exito as any);
      

            this.dataSource = this.turnos;
            
          },
          error => alert("Error: " + JSON.stringify(error))
        );

       }

       
      });
    




  /*  this.conexion.Pedidos().subscribe(
      exito => {

      
        this.turnos = (exito as any);
   

        this.dataSource = this.turnos;
        
      },
      error => alert("Error: " + JSON.stringify(error))
    );*/





  }

  ngOnInit() {


    







  }


  /*pedirProducto(nombre,tipo,precio,tiempo,cantidad)
  {

    if(cantidad==0)
    {
      alert("no esta pidiendo nada");
      return;
    }


    this.conexion.Pedir(nombre,tipo,precio,tiempo).subscribe(
      exito => {

        //this.turnos = (exito as any).rta;
        this.turnos = (exito as any);
      //  this.misTurnos = this.turnos.filter((value)=> {
          //return value.correo == token.correo; 
        //  return value.correo == token.user;
        //});

        //this.dataSource = this.turnos;
      },
      error => alert("Error: " + JSON.stringify(error))
    );

    alert("Se hizo el pedido correctamente");


  }*/

  sumar(nombre)
  {
    //this.valor++;
    //numero=numero++;
    for(let i=0;i<this.dataSource.length;i++)
    {
      if(this.dataSource[i].nombre==nombre)
      {
        this.dataSource[i].cantidad++;
      }
    }
  
  }


  pedirr()
  {
    let probanding=false;

    for(let i=0;i<this.dataSource.length;i++)
    {
      if(this.dataSource[i].cantidad!=0)
      {
        //alert("No pidio nada");
        probanding=true;
      }
      
    }
    
    if(probanding==false)
    {
      alert("NO PIDIO NADA");
      return;
    }

    for(let i=0;i<this.dataSource.length;i++)
    {
      if(this.dataSource[i].cantidad!=0)
      {
        //this.dataSource[i].cantidad++;

        this.conexion.Pedir(this.dataSource[i].nombre,this.dataSource[i].tipo,this.dataSource[i].precio,this.dataSource[i].tiempo,this.dataSource[i].cantidad,this.nombre).subscribe(
          exito => {
    
            //this.turnos = (exito as any).rta;
            this.turnos = (exito as any);
          //  this.misTurnos = this.turnos.filter((value)=> {
              //return value.correo == token.correo; 
            //  return value.correo == token.user;
            //});
            alert("Se hizo el pedido con exito");
            //this.dataSource = this.turnos;
          },
          error => alert("Error: " + JSON.stringify(error))
        );



      }
    }

  }

}
