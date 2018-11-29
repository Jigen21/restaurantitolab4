import { Component, OnInit } from '@angular/core';
import { ConexionService } from "../../servicios/conexion.service";
import { JwtHelperService } from "@auth0/angular-jwt";

@Component({
  selector: 'app-administrar',
  templateUrl: './administrar.component.html',
  styleUrls: ['./administrar.component.css']
})
export class AdministrarComponent implements OnInit {

  public displayedColumns: string[] = ['nombre', 'tipo','modificar','eliminar'];
  public displayedColumnsFechas: string[] = ['correo', 'fecha'];
  public displayedColumnsOperaciones: string[] = ['tipo', 'cantidad'];
  public turnos = [];
  public misTurnos;
  public empleados;
  public correo;
  public tipo="mozo";
  public password;
  public fechas =[];
  public operaciones=[];
  

  constructor(private conexion: ConexionService)
   { 


    this.conexion.traerEmpleados().subscribe(
      exito => {

        //this.turnos = (exito as any).rta;
        this.turnos = (exito as any);
       this.misTurnos = this.turnos.filter((value)=> {
          return value.tipo!="cliente"; 
         // return value.correo == token.user;
       });

        this.empleados = this.misTurnos;
      },
      error => alert("Error: " + JSON.stringify(error))
    );


    this.conexion.traerFechas().subscribe(
      exito => {

        this.fechas = (exito as any);
       

        //this.empleados = this.misTurnos;
      },
      error => alert("Error: " + JSON.stringify(error))
    );

    this.conexion.traerOperaciones().subscribe(
      exito => {

        this.operaciones = (exito as any);
       

        //this.empleados = this.misTurnos;
      },
      error => alert("Error: " + JSON.stringify(error))
    );









   }

  ngOnInit() 
  {





  }


  suspender()
  {

  }

  eliminar(correo)
  {

    this.conexion.eliminarEmpleado(correo).subscribe(
      exito => {

        //this.turnos = (exito as any).rta;
      alert("Se elimino el empleado");
      },
      error => alert("Error: " + JSON.stringify(error))
    );


  }

  alta()
  {
    //alert("llegue");

    if(!this.correo || !this.password) 
    {
      
      alert("Todos los campos deben ser completados...");
      return;
    }

    var re = /\S+@\S+\.\S+/;

        if (!(re.test(this.correo))) 
        {
            alert  ("pone un mail valido porfa");
            return;
        }


        this.conexion.Alta(this.correo,this.tipo,this.password).subscribe(
          exito => {
    
            //alert(exito);
            alert("Se dio de alta el empleado");
            //this.turnos = (exito as any).rta;
        
          },
          error => alert("Error: " + JSON.stringify(error))
        );


  }



}
