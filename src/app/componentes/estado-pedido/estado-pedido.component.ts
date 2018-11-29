import { Component, OnInit } from '@angular/core';
import { ConexionService } from "../../servicios/conexion.service";
import { JwtHelperService } from "@auth0/angular-jwt";

@Component({
  selector: 'app-estado-pedido',
  templateUrl: './estado-pedido.component.html',
  styleUrls: ['./estado-pedido.component.css']
})
export class EstadoPedidoComponent implements OnInit {
  
  public nombre;
  public turnos = [];
  public dataSource;
  public estado="No Hizo Ningun Pedido";

  constructor(private conexion: ConexionService)
   {

    let JWTHelper = new JwtHelperService();
    let token;
    token = JWTHelper.decodeToken(localStorage.getItem("token"));
    
  
    this.nombre=token.correo;


    this.conexion.estadoPedido(this.nombre).subscribe(
      exito => {

        this.turnos = (exito as any);
        this.dataSource=this.turnos;

        let estaPedido=false;
        let estaTomado=false;
        let estaTerminado;
        let estaEntregado;

        for(let i=0;i<this.turnos.length;i++)
        {

          if(this.turnos[i].estado=="pedido")
          {
             // this.estado="Todavia no realizo ningun pedido";
             estaPedido=true;
              //alert("todavia no puede pagar");
              
          }
          else
          {
            estaPedido=false;
          }

        
        }

        for(let j=0;j<this.turnos.length;j++)
        {

          if(this.turnos[j].estado=="tomado")
          {
             // this.estado="Todavia no realizo ningun pedido";
             estaTomado=true;
              //alert("todavia no puede pagar");
              
          }
          else
          {
            estaTomado=false;
          }

          
        }

        
        for(let j=0;j<this.turnos.length;j++)
        {

          if(this.turnos[j].estado=="terminado")
          {
             // this.estado="Todavia no realizo ningun pedido";
             estaTerminado=true;
              //alert("todavia no puede pagar");
              
          }
          else
          {
            estaTerminado=false;
          }

          
        }

        for(let j=0;j<this.turnos.length;j++)
        {

          if(this.turnos[j].estado=="entregado")
          {
             // this.estado="Todavia no realizo ningun pedido";
             estaEntregado=true;
              //alert("todavia no puede pagar");
              
          }
          else
          {
            estaEntregado=false;
          }

          
        }

        if(estaPedido==true)
        {
          this.estado="Falta que el mozo Confirme el pedido";
        }
        
        if(estaTomado==true)
        {
          this.estado="El mozo ya confirmo el pedido,falta que lo tomen los empleados correspondientes";
        }

        if(estaTerminado==true)
        {
          this.estado="El pedido ya esta terminado,falta que el mozo se lo lleve a la mesa";
        }

        if(estaEntregado==true)
        {
          this.estado="Su pedido ya esta en la mesa,de no ser asi comuniquese con el mozo correspondiente";
        }
        





      },
      error => alert("Error: " + JSON.stringify(error))
    );



    }

  ngOnInit() {
  }

}
