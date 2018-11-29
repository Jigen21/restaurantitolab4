import { Component } from '@angular/core';
import { BreakpointObserver, Breakpoints, BreakpointState } from '@angular/cdk/layout';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { JwtHelperService } from "@auth0/angular-jwt";

@Component({
  selector: 'app-material-nav',
  templateUrl: './material-nav.component.html',
  styleUrls: ['./material-nav.component.css']
})
export class MaterialNavComponent {

  public nombre;
  public tipo;
  public nombreTipo;
  public ver;
  public verDos;
  public verPedidos;
  public verCliente;
  public verMozo;
  public verMozoyCliente;
  public verSupervisor;

  isHandset$: Observable<boolean> = this.breakpointObserver.observe(Breakpoints.Handset)
    .pipe(
      map(result => result.matches)
    );
    
  constructor(private breakpointObserver: BreakpointObserver) {

    let JWTHelper = new JwtHelperService();
    let token;

    token = JWTHelper.decodeToken(localStorage.getItem("token"));
    this.nombre = token.correo;
    this.tipo = token.tipo;
    this.nombreTipo=this.nombre+" "+this.tipo;
    
    if(this.tipo=="admin")
    {
      this.ver=true;
    }

    if(this.tipo=="cliente")
    {
      this.verDos=true;
      this.verCliente=true;
      this.verMozoyCliente=true;
    }

    if(this.tipo=="mozo")
    {
      this.verMozo=true;
      this.verMozoyCliente=true;
    }


    if(this.tipo=="cocinero"||this.tipo=="bartender"||this.tipo=="candybar"||this.tipo=="cervezero")
    {
      this.verPedidos=true;
    }

    if(this.tipo=="supervisor")
    {
      this.verSupervisor=true;
    }

  }

  Logout() {
    localStorage.clear();
    location.href = "./";
  }
  
}