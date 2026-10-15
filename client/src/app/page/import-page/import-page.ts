import { Component, inject } from '@angular/core';
import { Container } from '../../shared/container/container';
import { Form } from '../../shared/form/form';
import { Import } from '../../data/services/import';

@Component({
  imports: [Container, Form],
  selector: 'app-import-page',
  styleUrl: './import-page.css',
  templateUrl: './import-page.html',
})
export class ImportPage {
  private importService = inject(Import)


  upload(file: File) {
    this.importService.upload(file).subscribe({
      next: (response) => console.log('Импорт выполнен', response),
      error: (error) => console.error('Ошибка импорта', error),
    });
  }

}
