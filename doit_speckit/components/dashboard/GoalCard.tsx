"use client";

import { useState } from "react";
import { Goal } from "@/types/goal";
import { formatDaysRemaining, isUrgent } from "@/lib/dates";
import { Checkbox } from "@/components/ui/checkbox";
import { Button } from "@/components/ui/button";
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogHeader,
  AlertDialogTitle,
} from "@/components/ui/alert-dialog";
import { Trash2 } from "lucide-react";

interface GoalCardProps {
  goal: Goal;
  onComplete: (id: string) => void;
  onDelete: (id: string) => void;
}

/**
 * Component to display an individual goal card
 * Shows goal title, days remaining, and action buttons
 * Applies urgent highlighting for goals within 3 days
 */
export function GoalCard({ goal, onComplete, onDelete }: GoalCardProps) {
  const [showDeleteConfirm, setShowDeleteConfirm] = useState(false);
  const daysRemaining = formatDaysRemaining(goal.endDate);
  const urgent = isUrgent(goal.endDate);

  const handleConfirmDelete = () => {
    onDelete(goal.id);
    setShowDeleteConfirm(false);
  };

  return (
    <>
      <div
        className={`flex items-center gap-3 p-4 rounded-lg border ${
          urgent
            ? "bg-pastel-yellow border-yellow-300"
            : goal.status === "completed"
              ? "bg-pastel-pink border-pink-200"
              : "bg-white border-gray-200"
        }`}
      >
        {/* Checkbox for current goals, hidden for completed */}
        {goal.status === "current" && (
          <Checkbox
            checked={false}
            onCheckedChange={() => onComplete(goal.id)}
            className="h-5 w-5"
            aria-label={`Complete goal: ${goal.title}`}
          />
        )}

        {/* Goal content */}
        <div className="flex-1 min-w-0">
          <h3 className="font-semibold text-sm truncate text-gray-900">
            {goal.title}
          </h3>
          <p className={`text-xs mt-1 ${urgent ? "font-semibold" : ""}`}>
            {daysRemaining}
            {urgent && " (Urgent)"}
          </p>
        </div>

        {/* Delete button */}
        <Button
          variant="ghost"
          size="sm"
          onClick={() => setShowDeleteConfirm(true)}
          className="flex-shrink-0 text-gray-500 hover:text-red-600 h-9 w-9 p-0"
          aria-label={`Delete goal: ${goal.title}`}
        >
          <Trash2 className="h-4 w-4" />
        </Button>
      </div>

      {/* Delete confirmation dialog */}
      <AlertDialog open={showDeleteConfirm} onOpenChange={setShowDeleteConfirm}>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Delete Goal</AlertDialogTitle>
            <AlertDialogDescription>
              Are you sure you want to delete &ldquo;{goal.title}&rdquo;? This action cannot be undone.
            </AlertDialogDescription>
          </AlertDialogHeader>
          <div className="flex gap-3">
            <AlertDialogCancel asChild>
              <Button variant="outline" className="flex-1">
                Cancel
              </Button>
            </AlertDialogCancel>
            <AlertDialogAction asChild>
              <Button
                onClick={handleConfirmDelete}
                variant="destructive"
                className="flex-1"
              >
                Delete
              </Button>
            </AlertDialogAction>
          </div>
        </AlertDialogContent>
      </AlertDialog>
    </>
  );
}
