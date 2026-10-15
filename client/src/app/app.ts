import { Component, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { ImportPage } from './page/import-page/import-page';
import { Header } from './shared/header/header';

@Component({
  imports: [RouterOutlet, Header],
  selector: 'app-root',
  styleUrl: './app.css',
  templateUrl: './app.html',
})
export class App {
  
}
