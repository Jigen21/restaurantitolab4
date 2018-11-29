import { Component, OnInit } from '@angular/core';

import { ConexionService } from "../../servicios/conexion.service";
import { JwtHelperService } from "@auth0/angular-jwt";

@Component({
  selector: 'app-ver-mesas',
  templateUrl: './ver-mesas.component.html',
  styleUrls: ['./ver-mesas.component.css']
})
export class VerMesasComponent implements OnInit {

  //public displayedColumns: string[] = ['id', 'estado','cliente','mozo'];
  public displayedColumns: string[] = ['id', 'estado','sentarse'];
  public turnos = [];
  public misTurnos;
  public dataSource;
  public correo;
  public tipo;
  public verMozo;
  public nombre;
  public tieneMesa;
  public mesasPagadas;

  public displayedColumnsdos: string[]=['id','estado','liberar'];

  constructor(private conexion: ConexionService)
   {
     this.tieneMesa=false;
    let JWTHelper = new JwtHelperService();
    
    let token;
    token = JWTHelper.decodeToken(localStorage.getItem("token"));

    this.tipo = token.tipo;
    this.nombre=token.correo;

    if(this.tipo=="mozo")
    {
      this.verMozo=true;
      this.displayedColumns=['id', 'estado','cliente','tomar','mozo'];

      this.conexion.Mesas().subscribe(
        exito => {
  
          //this.turnos = (exito as any).rta;
          this.turnos = (exito as any);
          this.misTurnos = this.turnos.filter((value)=> {
            return value.estado == "ocupada"; 
            //return value.correo == token.user;
          });

          this.mesasPagadas = this.turnos.filter((value)=> {
            return value.estado == "pagado"; 
            //return value.correo == token.user;
          });
  
          //this.dataSource = this.turnos;
          this.dataSource = this.misTurnos;
        },
        error => alert("Error: " + JSON.stringify(error))
      );




    }
    if(this.tipo=="cliente")
    {

      this.conexion.estoySentado(this.nombre).subscribe(
        exito => {
  
          //this.turnos = (exito as any).rta;
          //alert("no esta sentado en ninguna mesa");
          //alert("Usted ya esta sentado en una mesa")
          //alert(exito);
         // this.tieneMesa=true;
         //alert(JSON.stringify(exito));
        // alert(exito);
        if(exito=="si")
         {
           alert("Usted ya esta sentado en una mesa");
           //this.tieneMesa=true;
         }
         if(exito=="no")
         {

          this.conexion.Mesas().subscribe(
            exito => {
      
              //this.turnos = (exito as any).rta;
              this.turnos = (exito as any);
              this.misTurnos = this.turnos.filter((value)=> {
                return value.estado == "libre"; 
                //return value.correo == token.user;
              });
      
              this.dataSource = this.misTurnos;
            },
            error => alert("Error: " + JSON.stringify(error))
          );


         }
        
          //return;
         
        },
        error => alert("Error: " + JSON.stringify(error))
      );




    }


   /* if(this.tieneMesa==false)
    {
      this.conexion.Mesas().subscribe(
        exito => {
  
          //this.turnos = (exito as any).rta;
          this.turnos = (exito as any);
          this.misTurnos = this.turnos.filter((value)=> {
            return value.estado == "libre"; 
            //return value.correo == token.user;
          });
  
          this.dataSource = this.misTurnos;
        },
        error => alert("Error: " + JSON.stringify(error))
      );
  



    }*/


   
    }

  ngOnInit() {
  }



  ocuparMesa(id)
  {

    let JWTHelper = new JwtHelperService();
    
    let token;
    token = JWTHelper.decodeToken(localStorage.getItem("token"));

    this.correo = token.correo;


    //alert("la ocupe");

    this.conexion.OcuparMesa(id,this.correo).subscribe(
      exito => {

        //this.turnos = (exito as any).rta;
        this.turnos = (exito as any);
      //  this.misTurnos = this.turnos.filter((value)=> {
          //return value.correo == token.correo; 
        //  return value.correo == token.user;
        //});
        alert("Se sento con exito");

        //this.dataSource = this.turnos;
      },
      error => alert("Error: " + JSON.stringify(error))
    );



  }

  entregarPedido(id)
  {

    this.conexion.entregarPedido(id).subscribe(
      exito => {

        //alert("pedidos de la mesa 1 entregados");
        //alert(JSON.stringify(exito));
        alert("Pedido entregado con exito");
        //this.turnos = (exito as any).rta;
        //this.turnos = (exito as any);
      //  this.misTurnos = this.turnos.filter((value)=> {
          //return value.correo == token.correo; 
        //  return value.correo == token.user;
        //});

        //this.dataSource = this.turnos;
      },
      error => alert("Error: " + JSON.stringify(error))
    );



  }


  tomarPedido(id)
  {

    this.conexion.Tomado(id).subscribe(
      exito => {

       
        alert("Pedido tomado con exito");
     
      },
      error => alert("Error: " + JSON.stringify(error))
    );



  }

  liberarMesa(id)
  {

    this.conexion.liberarMesa(id).subscribe(
      exito => {

       
        //alert(exito);
        alert("se libero la mesa");
     
      },
      error => alert("Error: " + JSON.stringify(error))
    );



  }


}
