import { Component, inject } from '@angular/core';
import { Container } from '../../shared/container/container';
import { Form } from '../../shared/form/form';
import { Import } from '../../data/services/import/import';
import { Router } from '@angular/router';

@Component({
  imports: [Container, Form],
  selector: 'app-import-page',
  styleUrl: './import-page.css',
  templateUrl: './import-page.html',
})
export class ImportPage {
  private importService = inject(Import)
  private router = inject(Router);

  upload(file: File) {
    this.importService.upload(file).subscribe({
      next: (result) => {
        this.router.navigate(['/import', result.jobId]);
      },
      error: (err) => console.error(err)
    });
  }

}
